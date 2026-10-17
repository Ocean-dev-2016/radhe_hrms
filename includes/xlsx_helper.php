<?php
if (!function_exists('download_sample_xlsx')) {
    function download_sample_xlsx($filename, $headers, $rows = [], $required_map = [])
    {
        if (!class_exists('ZipArchive')) {
            header('Content-Type: text/plain; charset=utf-8');
            echo 'ZipArchive extension is required for XLSX download.';
            exit;
        }

        $xml_escape = function ($value) {
            return htmlspecialchars((string) $value, ENT_QUOTES | ENT_XML1, 'UTF-8');
        };

        $col_to_name = function ($index) {
            $index = intval($index);
            $name = '';
            while ($index >= 0) {
                $name = chr(($index % 26) + 65) . $name;
                $index = intdiv($index, 26) - 1;
            }
            return $name;
        };

        // Track maximum character length per column for auto-sizing widths
        $col_widths = [];
        foreach ($headers as $idx => $header_val) {
            $col_widths[$idx] = mb_strlen((string) $header_val, 'UTF-8');
        }

        $build_row = function ($row_index, $values, $is_header = false) use ($xml_escape, $col_to_name, $required_map, &$col_widths) {
            $row_xml = '<row r="' . $row_index . '">';
            $cell_count = count($values);
            for ($i = 0; $i < $cell_count; $i++) {
                $cell_ref = $col_to_name($i) . $row_index;
                $raw_val = $values[$i] ?? '';
                $val = $xml_escape($raw_val);

                // Update max length for auto column width
                $str_len = mb_strlen((string) $raw_val, 'UTF-8');
                if (!isset($col_widths[$i]) || $str_len > $col_widths[$i]) {
                    $col_widths[$i] = $str_len;
                }

                $style = 0;
                if ($is_header) {
                    $header_key = strtolower(trim((string) ($values[$i] ?? '')));
                    $style = !empty($required_map[$header_key]) ? 1 : 2;
                    $row_xml .= '<c r="' . $cell_ref . '" t="inlineStr" s="' . $style . '"><is><t>' . $val . '</t></is></c>';
                } else {
                    $trimmed = trim((string) $raw_val);
                    // Check if value is numeric or phone number / currency / formatted number (allows digits, spaces, hyphens, dots, commas, leading +)
                    $clean_num = str_replace([' ', '-', ',', '+'], '', $trimmed);
                    $is_numeric = ($clean_num !== '' && is_numeric($clean_num) && !preg_match('/[a-zA-Z]/', $trimmed));
                    
                    if ($is_numeric) {
                        $style = 3; // Right-aligned
                        // If it's a clean standard number without spaces/leading plus/leading zeros, store as numeric <v>, else store as right-aligned text <inlineStr>
                        if (is_numeric($trimmed) && !preg_match('/^0\d+/', $trimmed)) {
                            $row_xml .= '<c r="' . $cell_ref . '" s="' . $style . '"><v>' . $trimmed . '</v></c>';
                        } else {
                            $row_xml .= '<c r="' . $cell_ref . '" t="inlineStr" s="' . $style . '"><is><t>' . $val . '</t></is></c>';
                        }
                    } else {
                        $style = 0; // Left-aligned text
                        $row_xml .= '<c r="' . $cell_ref . '" t="inlineStr" s="' . $style . '"><is><t>' . $val . '</t></is></c>';
                    }
                }
            }
            $row_xml .= '</row>';
            return $row_xml;
        };

        $sheet_rows = [];
        $sheet_rows[] = $build_row(1, $headers, true);
        $row_num = 2;
        foreach ($rows as $row) {
            $sheet_rows[] = $build_row($row_num, $row, false);
            $row_num++;
        }

        // Build <cols> XML with calculated widths (min 12, max 50, + 4 padding)
        $cols_xml = '<cols>';
        foreach ($headers as $idx => $hdr) {
            $col_num = $idx + 1;
            $len = $col_widths[$idx] ?? 10;
            $width = min(max($len + 4, 12), 55);
            $cols_xml .= '<col min="' . $col_num . '" max="' . $col_num . '" width="' . $width . '" customWidth="1"/>';
        }
        $cols_xml .= '</cols>';

        $sheet_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . $cols_xml
            . '<sheetData>' . implode('', $sheet_rows) . '</sheetData>'
            . '</worksheet>';

        $styles_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="3">'
            . '<font><sz val="11"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>'
            . '<font><b/><sz val="11"/><color rgb="FF1F2937"/><name val="Calibri"/></font>'
            . '</fonts>'
            . '<fills count="4">'
            . '<fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFEF4444"/><bgColor indexed="64"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFE2E8F0"/><bgColor indexed="64"/></patternFill></fill>'
            . '</fills>'
            . '<borders count="3">'
            . '<border><left/><right/><top/><bottom/><diagonal/></border>'
            . '<border>'
            . '<left style="medium"><color rgb="FF000000"/></left>'
            . '<right style="medium"><color rgb="FF000000"/></right>'
            . '<top style="medium"><color rgb="FF000000"/></top>'
            . '<bottom style="medium"><color rgb="FF000000"/></bottom>'
            . '</border>'
            . '<border>'
            . '<left style="thin"><color rgb="FFE2E8F0"/></left>'
            . '<right style="thin"><color rgb="FFE2E8F0"/></right>'
            . '<top style="thin"><color rgb="FFE2E8F0"/></top>'
            . '<bottom style="thin"><color rgb="FFE2E8F0"/></bottom>'
            . '</border>'
            . '</borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="4">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="2" xfId="0" applyBorder="1"><alignment horizontal="left" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="2" fillId="3" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1"><alignment horizontal="center" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="2" xfId="0" applyBorder="1"><alignment horizontal="right" vertical="center"/></xf>'
            . '</cellXfs>'
            . '</styleSheet>';

        $workbook_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            . 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Sample" sheetId="1" r:id="rId1"/></sheets>'
            . '</workbook>';

        $content_types_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>';

        $rels_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';

        $workbook_rels_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';

        $tmp_file = tempnam(sys_get_temp_dir(), 'xlsx_');
        $zip = new ZipArchive();
        $zip->open($tmp_file, ZipArchive::OVERWRITE);
        $zip->addFromString('[Content_Types].xml', $content_types_xml);
        $zip->addFromString('_rels/.rels', $rels_xml);
        $zip->addFromString('xl/workbook.xml', $workbook_xml);
        $zip->addFromString('xl/_rels/workbook.xml.rels', $workbook_rels_xml);
        $zip->addFromString('xl/styles.xml', $styles_xml);
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheet_xml);
        $zip->close();

        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Length: ' . filesize($tmp_file));
        header('Cache-Control: max-age=0');
        readfile($tmp_file);
        @unlink($tmp_file);
        exit;
    }
}

