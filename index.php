<?php
    function getWeatherStringEmmen()
    {   
        $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
        $yql_query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="Emmen, NL")';
        $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=xml";

        $reader = new XMLReader();
        $tempLocation = 0;
        $tempText = '';
        $tempCode = '';
        $location = '';

        if (!$reader->open($yql_query_url))
        {
            print "can't read link";
        }

        while ($reader->read())
        {
            if ($reader->nodeType == XMLReader::ELEMENT)
            {
                $name = $reader->name;

                if ($name == 'yweather:location')
                {
                    $location = $reader->getAttribute('city');
                }

                if ($name == 'yweather:condition')
                {
                    $tempText = $reader->getAttribute('text');
                    $tempCode = $reader->getAttribute('code');
                    $tempLocation = $reader->getAttribute('temp');
                }
            }

            if (in_array($reader->nodeType, array(XMLReader::TEXT, XMLReader::CDATA, XMLReader::WHITESPACE, XMLReader::SIGNIFICANT_WHITESPACE)) && $name != '')
            {
                $value = $reader->value;
            }
        }
        return $location . " " . $tempLocation . " " . $tempCode . " " . $tempText;
    }

    $weatherstring = getWeatherStringEmmen();
    $location = explode(" ", $weatherstring, 4);
    $temp = round(($location[1]- 32) * 5 / 9 );

    $weathercode = $location[2];

    if ($weathercode == 0 || $weathercode == 1 || $weathercode == 2)
    {
        $status = "orkaan <style>.section{background-color: darkgrey;}</style>"; //orkaan
    }
    elseif($weathercode == 3 || $weathercode == 4 || $weathercode == 37 || $weathercode == 38 || $weathercode == 39 )
    {
        $status = "storm <style>.section{background-color: grey;}</style>"; //storm
    }
    elseif($weathercode == 5 || $weathercode == 6 || $weathercode == 7 || $weathercode == 8 || $weathercode == 9 || 
    $weathercode == 10 || $weathercode == 13 || $weathercode == 14 || $weathercode == 15 || $weathercode == 16 || 
    $weathercode == 17 || $weathercode == 18 || $weathercode == 41 || $weathercode == 42)
    {
        $status = "sneeuw <style>.section{background-color: white;}</style>"; //sneeuw
    }
    elseif($weathercode == 11 || $weathercode == 12 || $weathercode == 35 || $weathercode == 40 )
    {
        $status = "regen <style>.section{background-color: blue;}</style>";   // regen
    }
    elseif( $weathercode == 19 || $weathercode == 20 || $weathercode == 21|| $weathercode == 22)
    {
        $status = "mist <style>.section{background-color: white;}</style>"; //mist
    }
    elseif(  $weathercode == 23 || $weathercode == 24 )
    {
        $status = "wind <style>.section{background-color: white;}</style>"; // wind
    }
    elseif($weathercode == 25 )
    {
        $status = "ijsster <style>.section{background-color: white;}</style>"; //ijsster
    }
    elseif($weathercode == 26 )
    {
        $status = "bewolkt <style>.section{background-color: grey;}</style>";  //wolkje
    }
    elseif($weathercode == 27 || $weathercode == 29 )
    {
        $status = "bewolkt <style>.section{background-color: lightgrey;}</style>";    //wolk met maan
    }
    elseif($weathercode == 28 || $weathercode == 30 )
    {
        $status = "bewolkt/zonnig <style>.section{background-color: lightyellow;}</style>";   // wolk met zon
    }
    elseif($varabletempcode == 32 || $varabletempcode == 34 || $varabletempcode == 36)
    {
        $status = "zonnig <style>.section{background-color: yellow;}</style>"; // zon
    }
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Sjihdazi portfolio</title>
        <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans|PT+Sans" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <meta charset="utf-8">
    </head>
    <body>
        <div class="container">
            <div id="voorstellen" class="section">
                <div class="content">
                    <h1>Intrests</h1>
                    <div id="card">
                        <img src="cod.jpg" width="400">
                        <p>Ik speel tegenwoordig veel call op duty black ops 4. Dit is de nieuwste game in de serie en eindelijk weer een keer een goede game van activision.</p>
                        <p>Trusted reviews: 'Call of Duty: Black Ops 4 gives the somewhat stale franchise a new lease of life with this multiplayer-only experience.'</p>
                    </div>
                    <div id="card">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/ooyjaVdt-jA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <p>Hier is de trailer van call of duty black ops 4</p>
                    </div>
                </div>
            </div>
            <div id="hobby" class="section">
                <div class="content">
                    <h1>Form</h1>
                    <div id="card">
                        <form action="" method="post">
                            <input type="text" name="text" placeholder="type anything here"><br><br>
                            <input type="textarea" name="textarea" placeholder="type anything here"><br><br>
                            <input type="checkbox" name="vehicle1" value="Bike"> I have a bike<br><br>
                            what do you like:
                            <select name="cars">
                                <option value="volvo">Volvo</option>
                                <option value="saab">Saab</option>
                                <option value="fiat">Fiat</option>
                                <option value="audi">Audi</option>
                            </select>
                            <br><br>
                            What are you:<br>
                            <input type="radio" name="gender" value="male" checked> Male<br>
                            <input type="radio" name="gender" value="female"> Female<br><br>
                            <input type="submit" value="Submit" name="submit">
                        </form>
                        <?php
                            if (isset($_POST['submit']) && !empty($_POST['vehicle1'])) {
                                echo "<p>You are a ".$_POST['gender']." who would like to drive a ".$_POST['cars'].". And you own a bike.</p>";
                                echo "<p>You typed this in the text input: ".$_POST['text']."</p>";
                                echo "<p>You typed this in the textarea ".$_POST['textarea']."</p>";
                            }
                            elseif (isset($_POST['submit']) && !empty($_POST['vehicle1'])) {
                                echo "<p>You are a ".$_POST['gender']." who would like to drive a ".$_POST['cars'].". And you do not own a bike.</p>";
                                echo "<p>You typed this in the text input: ".$_POST['text']."</p>";
                                echo "<p>You typed this in the textarea ".$_POST['textarea']."</p>";
                            }
                        ?>
                    </div>

                </div>
            </div>
            <div class="section">
                <div class="content">
                    <h1>Weather</h1>
                    <div id="card">
                    <?php
                        echo "<p>".$location[0]."</p>";
                        echo "<p>".$temp."&#8451;</p>";
                        echo "<p>".$status."</p>";
                    ?>
                    </div>
                </div>
            </div>
            <div id="voorstellen" class="section">
                <div class="content">
                    <h1>RSS</h1>
                    <?php
                       $rss = new DOMDocument();
                        $rss->load('https://nl.hardware.info/updates/news.rss');
                        $feed = array();
                        foreach ($rss->getElementsByTagName('item') as $node) 
                        {
                            $item = array 
                            ( 
                                'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                                'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                                'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                                'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
                            );
                            array_push($feed, $item);
                        }
                        $limit = 5;
                        for($x=0;$x<$limit;$x++) 
                        {
                            $title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
                            $link = $feed[$x]['link'];
                            $description = $feed[$x]['desc'];
                            $date = date('l F d, Y', strtotime($feed[$x]['date']));
                            echo "<div id='card'>";
                            echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
                            echo '<small><em>Posted on '.$date.'</em></small></p>';
                            echo '<p>'.$description.'</p>';
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
