<?php

declare(strict_types=1);

namespace BeastBytes\Mermaid\Flowchart;

enum NodeShape: string
{
    case bang = 'bang';
    case card = 'card';
    case circle = 'circle';
    case cloud = 'cloud';
    case collate = 'collate';
    case comLink = 'com-link';
    case comment = 'braces';
    case commentLeft = 'brace-l';
    case commentRight = 'brace-r';
    case dataInputOutput = 'lean-r';
    case dataOutputInput = 'lean-l';
    case database = 'database';
    case decision = 'decision';
    case delay = 'delay';
    case directAccessStorage = 'das';
    case diskStorage = 'disk';
    case display = 'display';
    case dividedProcess = 'divided-process';
    case document = 'document';
    case doubleCircle = 'double-circle';
    case event = 'event';
    case extract = 'extract';
    case fork = 'fork';
    case icon = 'icon';
    case image = 'image';
    case internalStorage = 'internal-storage';
    case join = 'join';
    case junction = 'junction';
    case linedDocument = 'lined-document';
    case linedProcess = 'Lined-process';
    case loopLimit = 'loop-limit';
    case manualFile = 'manual-file';
    case manualInput = 'manual-input';
    case manualOperation = 'manual';
    case multiDocument = 'documents';
    case multiProcess = 'processes';
    case odd = 'odd';
    case paperTape = 'paper-tape';
    case prepareConditional = 'prepare';
    case priority = 'priority';
    case process = 'process';
    case shadedProcess = 'Shaded-process';
    case start = 'start';
    case stop = 'stop';
    case storedData = 'stored-data';
    case subprocess = 'subprocess';
    case summary = 'summary';
    case taggedDocument = 'tagged-document';
    case taggedProcess = 'tagged-process';
    case terminalPoint = 'terminal';
    case textBlock = 'text';
}