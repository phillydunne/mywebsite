<?php
class Club
{
    private $name;
    private $type;
    private $country;
    private $numberOfCourts;

    public function setAllClubProperties(string $name, string $type, string $country, int $numberOfCourts) {
        $this->name = $name;
        $this->type = $type;
        $this->country = $country;
        $this->numberOfCourts = $numberOfCourts;

//        echo "The name of this club is " . $this->
    }

    public function getNumberOfCourts() {
        echo $this->numberOfCourts;
        return $this->numberOfCourts;
    }

    public function storeAllClubProperties() {
        // Update the relevant database tables, return TRUE if there are no exceptions, FALSE if not.
        return TRUE;
    }

}
?>

<?php

$myClub = new Club;

$myClub->setAllClubProperties("Green Valley Tennis Club", "Tennis", "Ireland", "10");

echo "<br>This club has " . $myClub->getNumberOfCourts() . " courts<br>";

?>