<?php

//Define the equip slot constants.
define( "SLOT_HEAD", 1 );
define( "SLOT_SHOULDERS", 3 );
define( "SLOT_SHIRT", 4 );
define( "SLOT_CHEST", 5 );
define( "SLOT_WAIST", 6 );
define( "SLOT_LEGS", 7 );
define( "SLOT_FEET", 8 );
define( "SLOT_WRISTS", 9 );
define( "SLOT_HANDS", 10 );
define( "SLOT_OFFHAND", 14 );
define( "SLOT_BACK", 16 );
define( "SLOT_TABARD", 19 );
define( "SLOT_MAINHAND", 21 );

//Define race constants.
define( "RACE_HUMAN", "human" );
define( "RACE_ORC", "orc" );
define( "RACE_DWARF", "dwarf" );
define( "RACE_NIGHTELF", "nightelf" );
define( "RACE_UNDEAD", "undead" );
define( "RACE_TAUREN", "tauren" );
define( "RACE_GNOME", "gnome" );
define( "RACE_TROLL", "troll" );
define( "RACE_BLOODELF", "bloodelf" );
define( "RACE_DRAENEI", "draenei" );
define( "RACE_GOBLIN", "goblin" );
define( "RACE_WORGEN", "worgen" );
define( "RACE_PANDAREN", "pandaren" );

//Define gender constants.
define( "GENDER_MALE", "male" );
define( "GENDER_FEMALE", "female" );

class ModelViewer
{
    protected $EquippedItems = array();
    protected $Race = RACE_HUMAN;
    protected $Gender = GENDER_MALE;

    /*
     * Variable: ObjectWidth (int)
     *
     * Specifies the value of the 'width' attribute for the generated <object> HTML tag.
    */ 
    public $ObjectWidth = 600;
    
    /*
     * Variable: ObjectHeight (int)
     *
     * Specifies the value of the 'width' attribute for the generated <object> HTML tag.
    */ 
    public $ObjectHeight = 400;

    /*
     * Method: SetRace()
     *
     * Sets the race/species of the character model to the specified ID.
     *
     * ---
     *
     * Param: RaceId (string) - Race identifier in string format.
     *
     * Return: (none)
    */
    public function SetRace( $RaceId )
    {
        $Name = "RACE_" . strtoupper( $RaceId );

        if( !defined( $Name ) )
        {
            trigger_error( "'$RaceId' is not recognized as a valid race.", E_USER_WARNING );
            $RaceId = RACE_HUMAN;
        }

        $this->Race = $RaceId;
    }

    /*
     * Method: GetRace()
     * 
     * Returns the current character model race/species.
     *
     * ---
     * 
     * Return: (string)
    */
    public function GetRace()
    {
        return $this->Race;
    }

    /*
     * Method: SetGender()
     *
     * Sets the gender of the character model to the specified ID.
     *
     * ---
     *
     * Param: GenderId (string) - Gender identifier in string format.
     *
     * Return: (none)
    */
    public function SetGender( $GenderId )
    {
        $Name = "GENDER_" . strtoupper( $GenderId );

        if( !defined( $Name ) )
        {
            trigger_error( "'$GenderId' is not recognized as a valid gender.", E_USER_WARNING );
            $GenderId = GENDER_MALE;
        }

        $this->Gender = $GenderId;
    }

    /*
     * Method: GetGender()
     *
     * Returns the current gender of the character model.
     *
     * ---
     *
     * Return: (string)
    */
    public function GetGender()
    {
        return $this->Gender;
    }

    /*
     * Method: EquipItem()
     *
     * Sets a display ID of an item in the specified equip slot.
     *
     * ---
     *
     * Param: SlotId (int) - The specified slot ID to equip the item.
     * Param: DisplayId (int) - The specified display ID of the item to equip.
     *
     * Return: (none)
    */
    public function EquipItem( $SlotId, $DisplayId )
    {
        if( $SlotId != 1 && $SlotId != 14 && $SlotId != 16 && $SlotId != 19 && $SlotId != 21 && ( !($SlotId >= 3) && !($SlotId <= 10) ) )
            trigger_error( "Slot ID '$SlotId' is not a valid slot type.", E_USER_WARNING );

        $this->EquippedItems[$SlotId] = $DisplayId;
    }

    /*
     * Method: UnequipItem()
     *
     * Removes the item in the specified equip slot.
     *
     * ---
     *
     * Param: SlotId (int) - The specified slot ID to remove the item from.
     *
     * Return: (none)
    */
    public function UnequipItem( $SlotId )
    {
        if( isset( $this->EquippedItems[$SlotId] ) )
            unset( $this->EquippedItems[$SlotId] );
    }
    
    /*
     * Method: UnequipAll()
     *
     * Removes all currently equipped items.
     *
     * ---
     *
     * Return: (none)
    */
    public function UnequipAll()
    {
        unset( $this->EquippedItems );
        $this->EquippedItems = array();
    }

    /*
     * Method: IsSlotEquipped()
     *
     * Returns whether or not the specified equip slot currently has an item in it.
     *
     * ---
     *
     * Param: SlotId (int) - The equip slot to check.
     *
     * Return: (bool) - True if the slot contains an item, false otherwise.
    */
    public function IsSlotEquipped( $SlotId )
    {
        return isset( $this->EquippedItems[$SlotId] );
    }

    /*
     * Method: GetEquippedItem()
     *
     * Returns the display ID of the item in the specified slot.
     *
     * ---
     *
     * Param: SlotId (int) - The equip slot to check.
     *
     * Return: (int) - The display ID of the item in the specified slot, or -1 if the slot does not contain an item.
    */
    public function GetEquippedItem( $SlotId )
    {
        if( !$this->IsSlotEquipped( $SlotId ) )
            return -1;
        else
            return $this->EquippedItems[$SlotId];
    }

    /*
     * Mthod: GetCharacterHtml()
     *
     * Returns the HTML <object> tag for the character model viewer with all relevant data.
     *
     * ---
     *
     * Return: (string) - The HTML code for the character model viewer.
    */
    public function GetCharacterHtml()
    {
        $HtmlFormat = <<<HTML
<object type="application/x-shockwave-flash" data="http://wow.zamimg.com/modelviewer/ZAMviewerfp11.swf" width="%u" height="%u" id="dsjkgbdsg2346" style="visibility: visible;">
    <param name="quality" value="high">
    <param name="allowscriptaccess" value="always">
    <param name="allowfullscreen" value="false">
    <param name="menu" value="false">
    <param name="bgcolor" value="#181818">
    <param name="wmode" value="direct">
    <param name="flashvars" value="model=%s&amp;modelType=16&amp;contentPath=http://wow.zamimg.com/modelviewer/&amp;%s">
</object>
HTML;

        $ModelType = $this->Race . $this->Gender;
        $EquipList = "";

        if( sizeof( $this->EquippedItems ) > 0 )
        {
            $EquipList = "equipList=";

            foreach( $this->EquippedItems AS $Slot => $DisplayId )
                $EquipList .= "$Slot,$DisplayId,";

            $EquipList = rtrim( $EquipList, "," );
        }

        return sprintf( $HtmlFormat, $this->ObjectWidth, $this->ObjectHeight, $ModelType, $EquipList );
    }
    
    /*
     * Method: GetWeaponHtml()
     *
     * Returns the HTML <object> tag for the weapon model viewer.
     *
     * ---
     *
     * Param: SlotId (int) - The slot ID to pull the weapon display ID from. Restricted to SLOT_MAINHAND or SLOT_OFFHAND only.
     *
     * Return: (mixed) - Returns the HTML code for the weapon model viewer with all relevant data, or null on error.
    */
    public function GetWeaponHtml( $SlotId = SLOT_MAINHAND )
    {
        if( $SlotId != SLOT_MAINHAND && $SlotId != SLOT_OFFHAND )
        {
            trigger_error( "Invalid slot type, ModelViewer::DisplayWeapon() can only display the mainhand or offhand slot.", E_USER_WARNING );
            return null;
        }
        
        if( !isset( $this->EquippedItems[$SlotId] ) )
        {
            trigger_error( "There is no item equipped in the specified slot.", E_USER_WARNING );
            return null;
        }
        
        $HtmlFormat = <<<HTML
<object type="application/x-shockwave-flash" data="http://wow.zamimg.com/modelviewer/ZAMviewerfp11.swf" width="%u" height="%u" id="dsjkgbdsg2346" style="visibility: visible;">
    <param name="quality" value="high">
    <param name="allowscriptaccess" value="always">
    <param name="allowfullscreen" value="true"><param name="menu" value="false">
    <param name="bgcolor" value="#181818">
    <param name="wmode" value="direct">
    <param name="flashvars" value="model=%u&amp;modelType=1&amp;contentPath=http://wow.zamimg.com/modelviewer/">
</object>
HTML;

        return sprintf( $HtmlFormat, $this->ObjectWidth, $this->ObjectHeight, $this->EquippedItems[$SlotId] );
    }
    
    /*
     * Method: LookupDisplayId()
     *
     * Gets the display ID for an item of the given entry ID from Wowhead.com.
     *
     * ---
     *
     * Param: EntryId (int) - The entry ID of the item to lookup.
     *
     * Return: (mixed) - Returns the display ID as an integer on success, or null on error.
    */
    public static function LookupDisplayId( $EntryId )
    {
        if( !is_int( $EntryId ) )
        {
            trigger_error( "'$EntryId' is not a valid item entry ID.", E_USER_WARNING );
            return null;
        }
        
        $Url = sprintf( "http://www.wowhead.com/item=%u?xml", $EntryId );
        $Xml = file_get_contents( $Url );
        $Xml = simplexml_load_string( $Xml );
        
        if( isset( $Xml->error ) )
        {
            trigger_error( $Xml->error, E_USER_WARNING );
            return null;
        }
        
        $DisplayId = $Xml->item->icon["displayId"];
        
        return intval( $DisplayId );
    }
}

?>