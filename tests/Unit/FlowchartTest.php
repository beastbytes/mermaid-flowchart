<?php

use BeastBytes\Mermaid\Direction;
use BeastBytes\Mermaid\Flowchart\Arrowhead;
use BeastBytes\Mermaid\Flowchart\EdgeStyle;
use BeastBytes\Mermaid\Flowchart\Flowchart;
use BeastBytes\Mermaid\Flowchart\Edge;
use BeastBytes\Mermaid\Flowchart\Node;
use BeastBytes\Mermaid\Flowchart\NodeShape;
use BeastBytes\Mermaid\Flowchart\SubGraph;
use BeastBytes\Mermaid\Mermaid;

defined('COMMENT') or define('COMMENT', 'Comment');
defined('NODE_ID') or define('NODE_ID', 'nodeId');
defined('TITLE') or define('TITLE', 'Title');

test('Simple Flowchart', function () {
    $flowchart = Mermaid::create(Flowchart::class)
        ->withNode(new Node(id: NODE_ID))
    ;

    expect($flowchart->render())
        ->toBe(<<<EXPECTED
<pre class="mermaid">
flowchart TB
  nodeId@{"shape":"process","label":"nodeId"}
</pre>
EXPECTED
        )
    ;
});

test('Flowchart with comment', function () {
    $flowchart = (new Flowchart())
        ->withComment(COMMENT)
        ->withNode(new Node(id: NODE_ID))
    ;

    expect($flowchart->render())
        ->toBe(<<<EXPECTED
<pre class="mermaid">
%% Comment
flowchart TB
  nodeId@{"shape":"process","label":"nodeId"}
</pre>
EXPECTED
        )
    ;
});

test('Flowchart with direction', function (Direction $direction) {
    $flowchart = Mermaid::create(Flowchart::class)
        ->withDirection($direction)
        ->withNode(new Node(id: NODE_ID))
    ;

    expect($flowchart->render())
        ->toBe(sprintf(<<<EXPECTED
<pre class="mermaid">
flowchart %s
  nodeId@{"shape":"process","label":"nodeId"}
</pre>
EXPECTED, $direction->name)
        )
    ;
})
    ->with([Direction::BT, Direction::LR, Direction::RL, Direction::TB])
;

test('Flowchart with title', function () {
    $flowchart = Mermaid::create(Flowchart::class, ['title' => TITLE])
        ->withNode(new Node(id: NODE_ID))
    ;

    expect($flowchart->render())
        ->toBe(<<<EXPECTED
<pre class="mermaid">
---
title: Title
---
flowchart TB
  nodeId@{"shape":"process","label":"nodeId"}
</pre>
EXPECTED
        )
    ;
});

test('Flowchart with classDefs', function () {
    $flowchart = Mermaid::create(Flowchart::class)
        ->withClassDef([
            'classDef0' => 'fill:white',
            'classDef1' => ['font-style' => 'italic']
        ])
        ->addClassDef(['classDef2' => [
            'fill' => '#f00',
            'color' => 'white',
            'font-weight' => 'bold',
            'stroke-width' => '2px',
            'stroke' => 'yellow'
        ]])
        ->withNode((new Node(id: NODE_ID))->withStyleClass('classDef1'))
    ;

    expect($flowchart->render())
        ->toBe(<<<EXPECTED
<pre class="mermaid">
flowchart TB
  nodeId:::classDef1@{"shape":"process","label":"nodeId"}
  classDef classDef0 fill:white;
  classDef classDef1 font-style:italic;
  classDef classDef2 fill:#f00,color:white,font-weight:bold,stroke-width:2px,stroke:yellow;
</pre>
EXPECTED
        )
    ;
});

test('Flowchart with multiple nodes and links', function () {
    $node0 = new Node(id: 'node0');
    $node1 = new Node(id: 'node1');
    $node2 = new Node(id: 'node2');
    $node3 = new Node(id: 'node3');

    $flowchart = Mermaid::create(Flowchart::class)
        ->withNode($node0, $node1, $node2)
        ->withLink(
            new Edge($node0, $node1),
            new Edge($node1, $node2)
        )
    ;

    expect($flowchart->render())
        ->toBe(<<<EXPECTED
<pre class="mermaid">
flowchart TB
  node0@{"shape":"process","label":"node0"}
  node1@{"shape":"process","label":"node1"}
  node2@{"shape":"process","label":"node2"}
  node0 --> node1
  node1 --> node2
</pre>
EXPECTED

        )
        ->and($flowchart
            ->addNode($node3)
            ->addLink(new Edge($node1, $node3))
            ->render()
        )
        ->toBe(<<<EXPECTED
<pre class="mermaid">
flowchart TB
  node0@{"shape":"process","label":"node0"}
  node1@{"shape":"process","label":"node1"}
  node2@{"shape":"process","label":"node2"}
  node3@{"shape":"process","label":"node3"}
  node0 --> node1
  node1 --> node2
  node1 --> node3
</pre>
EXPECTED
        )
    ;
});

test('Flowchart with subgraphs', function () {
    $node0 = new Node(id: 'node0');
    $node1 = new Node(id: 'node1');
    $node2 = new Node(id: 'node2');
    $node3 = new Node(id: 'node3');

    expect(Mermaid::create(Flowchart::class)
        ->withSubGraph(
            (new SubGraph('Subgraph 0'))
                ->withNode($node0, $node1)
                ->withLink(new Edge($node0, $node1))
            ,
            (new SubGraph('Subgraph 1', 'sg1', direction: Direction::LR))
                ->withNode($node2, $node3)
                ->withLink(new Edge($node2, $node3))
        )
        ->withLink(new Edge($node1, $node2))
        ->render()
    )
        ->toBe(<<<EXPECTED
<pre class="mermaid">
flowchart TB
  subgraph Subgraph 0
    direction TB
    node0@{"shape":"process","label":"node0"}
    node1@{"shape":"process","label":"node1"}
    node0 --> node1
  end
  subgraph sg1 [Subgraph 1]
    direction LR
    node2@{"shape":"process","label":"node2"}
    node3@{"shape":"process","label":"node3"}
    node2 --> node3
  end
  node1 --> node2
</pre>
EXPECTED
        )
    ;
});

test('Example', function () {

    $start = new Node(NodeShape::circle, 'start');
    $stop = new Node(NodeShape::doubleCircle, 'stop');

    $r = new subGraph('Reception', 'r');
    $isRegistered = new Node(NodeShape::decision, 'isRegistered');
    $register = new Node(NodeShape::document, 'register');

    $n = new subGraph('Nurse', 'n');
    $nurse = new Node(NodeShape::start, 'nurse');
    $nurseAvailable = new Node(NodeShape::decision, 'nurseAvailable');
    $wfn = new Node(NodeShape::delay, 'wfn');
    $assessPatient = new Node(NodeShape::process, 'assessPatient');
    $doctorNeeded = new Node(NodeShape::decision, 'doctorNeeded');
    $treatPatient = new Node(NodeShape::process, 'treatPatient');
    $assignDoctor = new Node(NodeShape::priority, 'assignDoctor');

    $d = new subGraph('Doctor', 'd');
    $doctorAvailable = new Node(NodeShape::decision,'doctorAvailable');
    $wfd = new Node(NodeShape::delay,'wfd');
    $consultation = new Node(NodeShape::process,'consultation');
    $medicationNeeded = new Node(NodeShape::decision,'medicationNeeded');
    $writePrescription = new Node(NodeShape::document,'writePrescription');
    $followUpNeeded = new Node(NodeShape::decision,'followUpNeeded');
    $makeAppointment = new Node(NodeShape::document,'makeAppointment');

    expect(Mermaid::create(Flowchart::class)
        ->withDirection(Direction::LR)
        ->withNode(
            $start->withText('Patient arrives'),
            $stop->withText('Patient leaves')
        )
        ->withSubGraph(
            $r
                ->withNode(
                    $isRegistered->withText('Patient registered?'),
                    $register->withText('Register patient')
                )
                ->withEdge(
                    new Edge($start, $isRegistered, EdgeStyle::thick),
                    (new Edge($isRegistered, $register))->withText('No'),
                    (new Edge($isRegistered, $nurse))->withText('Yes'),
                    new Edge($register, $isRegistered)
                )
            ,
            $n
                ->withNode(
                    $nurse->withText('Patient assigned to nurse'),
                    $nurseAvailable->withText('Nurse available?'),
                    $wfn->withText('Wait for nurse'),
                    $assessPatient->withText('Assess patient'),
                    $doctorNeeded->withText('Doctor needed?'),
                    $treatPatient->withText('Treat patient'),
                    $assignDoctor->withText('Assign doctor')
                )
                ->withEdge(
                    new Edge($nurse, $nurseAvailable),
                    (new Edge($nurseAvailable, $wfn))->withText('No'),
                    (new Edge($nurseAvailable, $assessPatient))->withText('Yes'),
                    new Edge($wfn, $nurseAvailable),
                    new Edge($assessPatient, $doctorNeeded, EdgeStyle::thick, arrowhead: Arrowhead::circle),
                    (new Edge($doctorNeeded, $treatPatient))->withText('No'),
                    new Edge($treatPatient, $stop, EdgeStyle::thick),
                    (new Edge($doctorNeeded, $assignDoctor))->withText('Yes'),
                    new Edge($assignDoctor, $doctorAvailable),
                )
            ,
            $d
                ->withNode(
                    $doctorAvailable->withText('Doctor available?'),
                    $wfd->withText('Wait for doctor'),
                    $consultation->withText('Consultation'),
                    $medicationNeeded->withText('Medication needed?'),
                    $writePrescription->withText('Write prescription'),
                    $followUpNeeded->withText('Follow-up needed?'),
                    $makeAppointment->withText('Make appointment'),
                )
                ->withEdge(
                    (new Edge($doctorAvailable, $wfd))->withText('No'),
                    (new Edge($doctorAvailable, $consultation))->withText('Yes'),
                    new Edge($wfd, $doctorAvailable),
                    new Edge($consultation, $medicationNeeded, arrowhead: Arrowhead::cross),
                    (new Edge($medicationNeeded, $followUpNeeded))->withText('No'),
                    (new Edge($medicationNeeded, $writePrescription))->withText('Yes'),
                    new Edge($writePrescription, $followUpNeeded),
                    (new Edge($followUpNeeded, $makeAppointment))->withText('Yes'),
                    (new Edge($followUpNeeded, $stop))->withText('No'),
                    new Edge($makeAppointment, $stop)
                )
        )
        ->render()
    )
        ->toBe(<<<EXPECTED
<pre class="mermaid">
flowchart LR
  subgraph r [Reception]
    direction TB
    isRegistered@{"shape":"decision","label":"Patient registered?"}
    register@{"shape":"document","label":"Register patient"}
    start ==> isRegistered
    isRegistered -->|"No"| register
    isRegistered -->|"Yes"| nurse
    register --> isRegistered
  end
  subgraph n [Nurse]
    direction TB
    nurse@{"shape":"start","label":"Patient assigned to nurse"}
    nurseAvailable@{"shape":"decision","label":"Nurse available?"}
    wfn@{"shape":"delay","label":"Wait for nurse"}
    assessPatient@{"shape":"process","label":"Assess patient"}
    doctorNeeded@{"shape":"decision","label":"Doctor needed?"}
    treatPatient@{"shape":"process","label":"Treat patient"}
    assignDoctor@{"shape":"priority","label":"Assign doctor"}
    nurse --> nurseAvailable
    nurseAvailable -->|"No"| wfn
    nurseAvailable -->|"Yes"| assessPatient
    wfn --> nurseAvailable
    assessPatient ==o doctorNeeded
    doctorNeeded -->|"No"| treatPatient
    treatPatient ==> stop
    doctorNeeded -->|"Yes"| assignDoctor
    assignDoctor --> doctorAvailable
  end
  subgraph d [Doctor]
    direction TB
    doctorAvailable@{"shape":"decision","label":"Doctor available?"}
    wfd@{"shape":"delay","label":"Wait for doctor"}
    consultation@{"shape":"process","label":"Consultation"}
    medicationNeeded@{"shape":"decision","label":"Medication needed?"}
    writePrescription@{"shape":"document","label":"Write prescription"}
    followUpNeeded@{"shape":"decision","label":"Follow-up needed?"}
    makeAppointment@{"shape":"document","label":"Make appointment"}
    doctorAvailable -->|"No"| wfd
    doctorAvailable -->|"Yes"| consultation
    wfd --> doctorAvailable
    consultation --x medicationNeeded
    medicationNeeded -->|"No"| followUpNeeded
    medicationNeeded -->|"Yes"| writePrescription
    writePrescription --> followUpNeeded
    followUpNeeded -->|"Yes"| makeAppointment
    followUpNeeded -->|"No"| stop
    makeAppointment --> stop
  end
  start@{"shape":"circle","label":"Patient arrives"}
  stop@{"shape":"double-circle","label":"Patient leaves"}
</pre>
EXPECTED
        )
    ;
});