<?php
    echo "The month is ";
    $month = date("M");
    echo $month;
    echo "<br>";


    $months = 4;
    switch($months)
    {
        case 1:
            echo "The month is Jan";
            break;

        case 2:
            echo "The month is Feb";
            break;

        case 3:
            echo "The month is Mar";
            break;

        case 4:
            echo "The month is Apr";
            break;

        case 5:
            echo "The month is May";
            break;

        case 6:
            echo "The month is Jun";
            break;

        case 7:
            echo "The month is Jul";
            break;

        case 8:
            echo "The month is Aug";
            break;

        case 9:
            echo "The month is Sep";
            break;

        case 10:
            echo "The month is Oct";
            break;

        case 11:
            echo "The month is Nov";
            break;

        case 12:
            echo "The month is Dec";
            break;
        default:
        echo "The month is unknown!";
    }
    echo "<br>";
?>