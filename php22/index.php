<?php
require_once './cookie.php';
$request = new Cookie;
$color = null;
$hitCount = 0;
$birthday = null;

if (isset($_COOKIE['counter'])) {
    $hitCount = $_COOKIE['counter'];
    $hitCount++;
    $request->set('counter', $hitCount, 60*60*24);
    $message1 = "Вы посещали наш сайт ".$hitCount." раз";
} else {
    $message1 = "Добро пожаловать на наш сайт!";
    $request->set('counter', 0, 60*60*24);
}

    $request->set('block', "true", 60*2);
}

    $date = $_COOKIE['date'];
    if($date !== date('d.m.Y G:i:s')) {
        $date1 = strtotime($date);
        $date2 = strtotime(date('d.m.Y G:i:s'));
        $date = floor(($date2-$date1)/60);
        $message3 = "Вы были последний раз на сайте ".$date." минут назад";
    } else {
        $message3 = "Вы были последний раз на сайте сейчас";
    }
    $request->set('date', date('d.m.Y G:i:s') , 60 * 60 * 24 * 365 * 10);
} else {
    $request->set('date', date('d.m.Y G:i:s') , 60 * 60 * 24 * 365 * 10);
}

if (isset($_POST['birthday']) && !empty($_POST['birthday'])) {
    $arr = explode('-', $_POST['birthday']);
    $day = $arr[2];
    $month = $arr[1];
    $year = date('Y');
    $birthDate = "$year-$month-$day";

    if(strtotime($birthDate)<time()){
        $year = date('Y')+1;
        $birthDate = "$year-$month-$day";
    }
    $request->set('birthday', $birthDate, 60 * 60 * 24 * 365 * 10);
    $birthday = $birthDate;
    $checkTime = strtotime($birthday) - time();
    $birthNow = floor($checkTime/(60*60*24));
    if($birthNow == 0) {
        $message4 = 'Поздравляем с Днем Рождения!';
    } else {
        $message4 = 'Сегодня '.date('d.m.Y', time()).'<br>'.'До Вашего дня рождения осталось '.$birthNow.' дней';
    }
} else if (isset($_COOKIE['birthday'])) {
    $birthday = $_COOKIE['birthday'];
    $checkTime = strtotime($birthday) - time();
    $birthNow = floor($checkTime/(60*60*24));
    if($birthNow == 0) {
        $message4 = 'Поздравляем с Днем Рождения!';
    } else {
        $message4 = 'Сегодня '.date('d.m.Y', time()).'<br>'.'До Вашего дня рождения осталось '.$birthNow.' дней';
    }
}

if (!empty($_POST['color'])) {
    $request->set('color', $_POST['color'], 60 * 60 * 24 * 365);
    $color = $_POST['color'];
} else if (isset($_COOKIE['color'])) {
    $color = $_COOKIE['color'];
}


if (!empty($_POST['item'])) {
    $i = 0;
    if (isset($_COOKIE["shopping"])) {
        foreach ($_COOKIE["shopping"] as $name => $value) {
            $i++;
        }
    }
    $request->set("shopping[$i]", $_POST['item'], 60 * 60 * 24);
}
?>

<html>
<head>
    <title>Php</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="menu.css">
    <?php
        if ($color == "dark") {
            echo "<link rel='stylesheet' href='styleDark.css'>";
        } else {
            echo "<link rel='stylesheet' href='style.css'>";
        }
    ?>
    <link href='http://fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
</head>

<body>
<?php

?>
    <header>
        <div class="logo">
            <img src="logo.jpg" alt="Фото" width="100px">
        </div>
        <div class="headerContent">
            <div class="pageName">
                <div id="pageNameValue">Lab work 3</div>
            </div>
        </div>
    </header>

    <h1>Сookies:</h1>

    <div class="allforms">
        <div class="forma" style="display: block;">
            <h4><?php echo $message1; ?></h4>
            <h4><?php echo $message2; ?></h4>
            <form method="post">
                <div class="banner <?php echo (isset($_COOKIE['block']) || !empty($_POST['block'])) ? 'block' : ''; ?>">
                    <div style="height: 200px; width: 800px; background-color: red; font-size: 90px;">РЕКЛАМА</div>
                    <button type="submit" name="block" value="Не показывать больше">Не показывать больше</button>
                </div>
                <h4><?php echo $message3; ?></h4>
                <h4><?php echo $message4; ?></h4>
            </form>
            <form method="post">
                <span>Выберите тему:</span>
                <div>
                    <select name="color">
                        <option value="light" <?php echo ($color == 'light') ? 'selected' : ''; ?>>Светлая</option>
                        <option value="dark" <?php echo ($color == 'dark') ? 'selected' : ''; ?>>Темная</option>
                    </select>
                </div>
                <br/>
                <label for="birthday">Ваша дата рождения:</label>
                <br/>
                <input type="date" name="birthday" id="birthday" <?php echo "value=".$birthday; ?>>
                <br/>
                <br/>
                <button type="submit">Отправить</button>
            </form>
        </div>
    </div>

    <div class="forma" style="display: block;">
        <h2>Shop:</h2>
<?php
    if (!empty($_POST['item'])) {
        echo "<h4>Item was added. Please press 'Update page' button.</h4>";
    } else {
        $tovars = [
            "1;PCI-card 1;PCI.jpg;1000",
            "2;PCI-card 2;logo.jpg;1200",
            "3;PCI-card 3;PCI.jpg;100",
            "4;PCI-card 4;logo.jpg;5000",
            "5;PCI-card 5;PCI.jpg;355",
            "6;PCI-card 6;logo.jpg;999",
            "7;PCI-card 7;PCI.jpg;1999",
            "8;PCI-card 8;logo.jpg;100",
            "9;PCI-card 9;PCI.jpg;5000",
        ];

        echo "<div class='buyItem'>";

        foreach ($tovars as $index => $tovar) {

            $tovarValues = explode(";", $tovar);

            list($id, $itemName, $imageUrl, $cost) = $tovarValues;

            echo "<form method='post'>
                    <h4>$itemName: \$$cost</h4>
                    <div>
                        <img src='$imageUrl' alt='Фото' width='100px'>
                    </div>
                    <input type='hidden' name='item' value='$tovar' />
                    <br/>
                    <button type='submit'>Buy</button>
                </form>";
        }

        echo "</div>";
    }
?>
    </div>

    <div class="forma" style="display: block;">
        <h2>Bag:</h2>
<?php

    $i = 0;
    $sum = 0;
    if (isset($_COOKIE["shopping"])) {
        foreach ($_COOKIE["shopping"] as $name => $value) {
            $value = htmlspecialchars($value);

            $valuesArray = explode(";", $value);

            list(,,, $cost) = $valuesArray;

            $sum += $cost;
            $i++;
        }
    }

    echo "In bag $i items for \$$sum.";
?>
    </div>

    <div class='menu' style='margin-bottom: 20px;'>
        <a href='http://php22/index.php'>
            <div>Обновить страницу</div>
        </a>
    </div>

    <script type="text/javascript">

        function getCookie(name) {
            let cookie = {};
            document.cookie.split(';').forEach(function(el) {
                let [k,v] = el.split('=');
                cookie[k.trim()] = v;
            })
            return cookie[name];
        }
    </script>
</body>

</html>