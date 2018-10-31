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
                        $status = "orkaan"; //orkaan
                    }
                    elseif($weathercode == 3 || $weathercode == 4 || $weathercode == 37 || $weathercode == 38 || $weathercode == 39 )
                    {
                        $status = "storm"; //storm
                    }
                    elseif($weathercode == 5 || $weathercode == 6 || $weathercode == 7 || $weathercode == 8 || $weathercode == 9 || 
                    $weathercode == 10 || $weathercode == 13 || $weathercode == 14 || $weathercode == 15 || $weathercode == 16 || 
                    $weathercode == 17 || $weathercode == 18 || $weathercode == 41 || $weathercode == 42)
                    {
                        $status = "sneeuw"; //sneeuw
                    }
                    elseif($weathercode == 11 || $weathercode == 12 || $weathercode == 35 || $weathercode == 40 )
                    {
                        $status = "regen";   // regen
                    }
                    elseif( $weathercode == 19 || $weathercode == 20 || $weathercode == 21|| $weathercode == 22)
                    {
                        $status = "mist"; //mist
                    }
                    elseif(  $weathercode == 23 || $weathercode == 24 )
                    {
                        $status = "wind"; // wind
                    }
                    elseif($weathercode == 25 )
                    {
                        $status = "ijsster"; //ijsster
                    }
                    elseif($weathercode == 26 )
                    {
                        $status = "bewolkt";  //wolkje
                    }
                    elseif($weathercode == 27 || $weathercode == 29 )
                    {
                        $status = "bewolkt";    //wolk met maan
                    }
                    elseif($weathercode == 28 || $weathercode == 30 )
                    {
                        $status = "bewolkt";   // wolk met zon
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

            </div>
        </div>
            <div id="hobby" class="section">
                <div class="content">
                    <h1>Form</h1>
                </div>
            </div>
            <div class="section">
                <div class="content">
                    <h1>Weather</h1>
                    <div id="weather">
                    <?php
                        echo "<p>".$location[0]."</p>";
                        echo "<p>".$temp."&#8451;</p>";
                        echo "<p>".$status."</p>";
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
