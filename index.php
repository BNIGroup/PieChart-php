<?php 
    $connect = mysqli_connect("localhost", "root", "", "blog");
    $query = "SELECT * FROM chart";
    $result = mysqli_query($connect, $query);

    if (!$connect) {
        die("connection failed" . mysqli_connect_error());
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pie Charts</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Link google chart API -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages: ["corechart"]});
            // Akan dihandle pada fungsi drawchart
            google.charts.setOnLoadCallback(drawchart);

            function drawchart() {
                var chart = new google.visualization.PieChart(document.getElementById('daily'));
                var data = google.visualization.arrayToDataTable([
                    ['Daily Activities', 'Percentage'],
                    <?php
                      while($row = mysqli_fetch_array($result))
                      {
                        echo "['".$row["tugas"]."'," .$row["persentase"]."],";
                      }
                    ?>
                ]);
                
                var options = {
                    title: 'Daily Activities',
                    pieHole: 0.4, // Lubang pada pie Chart, tapi pieHole tidak akan muncul jika is3D = true
                    is3D: true // Ganti dengan false jika tidak ingin berbentuk 3D
                };

                chart.draw(data, options)
            }
        </script>
        <?php 
            $connect = mysqli_connect("localhost", "root", "", "blog");
            $SELECT = "SELECT * FROM chart";
            $INSERT = "INSERT INTO chart (tugas, persentase) VALUES ('$tugas', '$persentase')";
            $result = mysqli_query($connect, $SELECT);
            $tugas = $_POST['tugas'];
            $persentase = $_POST['persentase'];

            if (!$connect) {
                echo "connection failed" . mysqli_connect_error();
            }

            if (mysqli_query($connect, $INSERT)){
                echo "nothing wrong until here";
            } else {
                echo "Error" . $INSERT . "<br>" . $mysqli_error($connect);
            }
        ?>
    </head>
    <body>
    <style>
        body {
            font-family: Roboto, Ubuntu, 'sans-serif', 'Franklin Gothic Medium';
            margin: 0
            font-size: 93.25%;
        }

        ::selection {
            background: transparent
        }

        .navbar {
            width: 100%;
            position: fixed;
            background: royalblue;
            padding: 0.8rem 0 0.8rem 4rem;
            z-index: 99;
            top: 0;
            left: 0;
            right: 0
        }

        .navbar > span {
            cursor: default;
            font-size: 123%;
            color: #fafafa;
            font-weight: 500
        }

        .container {
            margin-top: 5rem;
            margin-left: 18%
        }

        .container > form {
            margin-left: 100px;
        }

    </style>
    <div class="navbar"><span>Daily Activities</span></div>
        <div class="container">
            <form action="index.php" method="POST">
                <label for="tugas">Tugas</label>
                <input type="text" name="tugas">
                <label for="persentase">Persentase</label>
                <input type="text" name="persentase">
                <button type="submit">Submit</button>
            </form><br>
            <div id="daily" style="width: 900px; height: 500px;"></div>
        </div>
    </body>
</html>