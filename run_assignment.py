#!/usr/bin/env python3

import subprocess
import os
import sys

os.chdir('c:\\laragon\\www\\webpersonal')

php_path = 'c:\\laragon\\bin\\php\\php-8.1.10-Win32-vs16-x64\\php.exe'

try:
    result = subprocess.run([php_path, 'assign_products_manual.php'], 
                          capture_output=True, text=True, check=False)
    print(result.stdout)
    if result.stderr:
        print("STDERR:", result.stderr)
    print("\nReturn code:", result.returncode)
except Exception as e:
    print(f"Error: {e}")
    sys.exit(1)
