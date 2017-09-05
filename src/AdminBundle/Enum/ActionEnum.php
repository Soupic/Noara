<?php

namespace AdminBundle\Enum;

/*
 * class ActionEnum
 */
class ActionEnum
{
    //Constante qui servent à défiir si c'est un ajour une modification ou suppression
    const ADD = 1;
    const EDIT = 2;
    const REMOVE = 3;

    //Constante pour définir de quelle partie il s'agit
    const KEY_POST = "post";
    const KEY_RACE = "race";
    const KEY_CHAR = "characters";
}