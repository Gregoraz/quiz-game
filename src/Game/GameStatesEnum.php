<?php

namespace App\Game;

enum GameStatesEnum: string
{
    case START = 'Game start';
    case CONFIGURATION = 'Configuration';
    case GENERATING_QUESTIONS = 'Generating questions';
    case ASKED_QUESTION = 'Waiting for player answer';
    case ANSWERED_QUESTION = 'Question answered';
    case GENERATING_RANK = 'Generating rank';
    case UPDATING_STATS = 'Updating stats';
    case FINISHED = 'Finished';
}