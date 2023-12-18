<?php
if ($format == 'excel') {
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=$title.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title><?= $title ?></title>
    <?php if ($format == 'pdf') : ?>
        <style type="text/css">
            .table-data {
                width: 100%;
                border-collapse: collapse;
            }

            .table-data tr th,
            .table-data tr td {
                border: 1px solid black;
                font-size: 11pt;
                padding: 5px;
                font-family: Verdana;
            }

            .table-data th {
                background-color: grey;
            }
        </style>
    <?php endif; ?>
</head>

<body>
    <table class="table-data">
        <thead>
            <tr>
                <th>No.</th>
                <?php foreach ($kolom as $k) : ?>
                    <th><?= $k ?></th>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data as $d) :
            ?>
                <tr>
                    <td><?= $no ?></td>
                    <?php foreach ($db_kolom as $k) : ?>
                        <td><?= $d[$k] ?></td>
                    <?php endforeach ?>
                </tr>
                <?php $no++ ?>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php if ($format == 'pdf') : ?>
        <script type="text/javascript">
            window.print();
        </script>
    <?php endif; ?>
</body>

</html>