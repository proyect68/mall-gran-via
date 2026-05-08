$content = Get-Content -Path "backup_bueno_final.sql" -Raw
$tables = [regex]::Matches($content, 'CREATE TABLE public\.(\w+) \((.*?)\);', [System.Text.RegularExpressions.RegexOptions]::Singleline)

$results = @()

foreach ($table in $tables) {
    $tableName = $table.Groups[1].Value
    $colsBlock = $table.Groups[2].Value
    
    $lines = $colsBlock.Split("`n")
    foreach ($line in $lines) {
        $line = $line.Trim()
        if ($line -match '^CONSTRAINT' -or $line -eq "") { continue }
        
        $parts = $line.Split(" ", [System.StringSplitOptions]::RemoveEmptyEntries)
        if ($parts.Count -lt 1) { continue }
        
        $colName = $parts[0].Trim(',')
        $colType = $parts[1].Trim(',')
        $isNotNull = $line -match "NOT NULL"
        
        $results += [PSCustomObject]@{
            Table = $tableName
            Column = $colName
            Type = $colType
            Nullable = if ($isNotNull) { "No" } else { "Yes" }
            PK = "No"
            FK = "No"
            FK_Target = ""
        }
    }
}

# Add PKs
$pks = [regex]::Matches($content, 'ALTER TABLE ONLY public\.(\w+)\s+ADD CONSTRAINT \w+ PRIMARY KEY \((\w+)\);')
foreach ($pk in $pks) {
    $t = $pk.Groups[1].Value
    $c = $pk.Groups[2].Value
    foreach ($row in $results) {
        if ($row.Table -eq $t -and $row.Column -eq $c) {
            $row.PK = "Yes"
        }
    }
}

# Add FKs
$fks = [regex]::Matches($content, 'ALTER TABLE ONLY public\.(\w+)\s+ADD CONSTRAINT \w+ FOREIGN KEY \((\w+)\) REFERENCES public\.(\w+)\((\w+)\)')
foreach ($fk in $fks) {
    $st = $fk.Groups[1].Value
    $sc = $fk.Groups[2].Value
    $dt = $fk.Groups[3].Value
    $dc = $fk.Groups[4].Value
    foreach ($row in $results) {
        if ($row.Table -eq $st -and $row.Column -eq $sc) {
            $row.FK = "Yes"
            $row.FK_Target = "$dt.$dc"
        }
    }
}

$results | ConvertTo-Json
