import re

def parse_sql(file_path):
    with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()

    # Find all CREATE TABLE blocks
    tables = re.findall(r'CREATE TABLE public\.(\w+) \((.*?)\);', content, re.DOTALL)
    
    parsed_tables = {}
    for name, cols_block in tables:
        cols = []
        for line in cols_block.strip().split('\n'):
            line = line.strip()
            if not line or line.startswith('CONSTRAINT'):
                continue
            
            # Simple parsing of columns
            parts = line.split()
            if not parts: continue
            col_name = parts[0]
            col_type = parts[1] if len(parts) > 1 else 'unknown'
            
            # Check for NOT NULL
            is_null = 'NO' if 'NOT NULL' in line.upper() else 'YES'
            
            cols.append({
                'name': col_name,
                'type': col_type,
                'null': is_null
            })
        parsed_tables[name] = cols

    # Find all PKs (usually at the end of the file or in ALTER TABLE)
    pks = re.findall(r'ALTER TABLE ONLY public\.(\w+)\s+ADD CONSTRAINT \w+ PRIMARY KEY \((\w+)\);', content)
    for table_name, pk_col in pks:
        if table_name in parsed_tables:
            for col in parsed_tables[table_name]:
                if col['name'] == pk_col:
                    col['pk'] = True

    # Find all FKs
    fks = re.findall(r'ALTER TABLE ONLY public\.(\w+)\s+ADD CONSTRAINT \w+ FOREIGN KEY \((\w+)\) REFERENCES public\.(\w+)\((\w+)\)', content)
    for src_table, src_col, dst_table, dst_col in fks:
        if src_table in parsed_tables:
            for col in parsed_tables[src_table]:
                if col['name'] == src_col:
                    col['fk'] = True
                    col['fk_target'] = f"{dst_table}.{dst_col}"

    return parsed_tables

if __name__ == "__main__":
    import json
    data = parse_sql('backup_bueno_final.sql')
    print(json.dumps(data, indent=2))
