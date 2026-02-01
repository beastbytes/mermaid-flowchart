Usage
=====

Flowchart allows the creation Flowchart diagrams.

A simple flowchart consists of `Nodes` and `Edges` (links) between them.
More complex flowcharts may include sub-graphs to group flowchart nodes.

Nodes
-----

There are three (3) types of node:

* Node - has a shape and optionally descriptive text
* IconNode - The node is an icon
* ImageNode - The node is an image

Edges
-----

Edges are links between nodes and/or sub-graphs.
Edges can have a variety of line styles, arrowheads, and - if an edge is given an `EdgeId` - CSS styles.

Sub-graphs
----------

Sub-graphs allow grouping of nodes and other sub-graphs; sub-graphs can be nested to any depth.

Example
-------

PHP
+++

.. code-block:: php

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

    Mermaid::create(Flowchart::class)
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
    ;

Generated Mermaid
+++++++++++++++++

.. code-block:: html

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

Mermaid Diagram
+++++++++++++++

.. mermaid::

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
