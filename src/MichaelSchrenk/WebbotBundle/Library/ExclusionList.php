<?php

namespace MichaelSchrenk\WebbotBundle\Library;

class ExclusionList
{
    # The spider will exclude any links containing any of the following substrings
    // Exclude Google AdWords links
    // Exclude doubleclick banner ads
    public static $exclusion_array = ["googlesyndication", "doubleclick.net"];
}
