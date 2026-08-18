import sys
import csv
import xlrd

def xls_to_csv(xls_path, csv_path):
    workbook = xlrd.open_workbook(xls_path)
    sheet = workbook.sheet_by_index(0)
    
    with open(csv_path, 'w', newline='', encoding='utf-8') as f:
        writer = csv.writer(f)
        for row_idx in range(sheet.nrows):
            row_values = []
            for col_idx in range(sheet.ncols):
                cell = sheet.cell(row_idx, col_idx)
                if cell.ctype == xlrd.XL_CELL_DATE:
                    try:
                        date_tuple = xlrd.xldate_as_tuple(cell.value, workbook.datemode)
                        # format as YYYY-MM-DD
                        date_val = f"{date_tuple[0]:04d}-{date_tuple[1]:02d}-{date_tuple[2]:02d}"
                        row_values.append(date_val)
                    except Exception:
                        row_values.append(str(cell.value))
                elif cell.ctype == xlrd.XL_CELL_NUMBER:
                    val = cell.value
                    if val.is_integer():
                        row_values.append(str(int(val)))
                    else:
                        row_values.append(str(val))
                elif cell.ctype in (xlrd.XL_CELL_EMPTY, xlrd.XL_CELL_BLANK):
                    row_values.append('')
                elif cell.ctype == xlrd.XL_CELL_BOOLEAN:
                    row_values.append('1' if cell.value else '0')
                else:
                    # Strip whitespace from string cell value
                    val = str(cell.value)
                    row_values.append(val.strip() if isinstance(cell.value, str) else val)
            writer.writerow(row_values)

if __name__ == '__main__':
    if len(sys.argv) < 3:
        print("Usage: xls_to_csv.py <input_xls> <output_csv>")
        sys.exit(1)
    xls_to_csv(sys.argv[1], sys.argv[2])
