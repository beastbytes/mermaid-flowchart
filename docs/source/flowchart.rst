Flowchart Class
===============

.. php:class:: Flowchart

    Represents a Flowchart diagram

    .. php:method:: addEdge(Edge ...$edge)

        Add edge(s)

        :param Edge ...$edge: The edge(s)
        :returns: A new instance of ``Flowchart`` with the edge(s) added
        :rtype: Flowchart

    .. php:method:: addNode(Node ...$node)

        Add node(s) and/or sub-graphs

        :param Node ...$node: The node(s)
        :returns: A new instance of ``Flowchart`` with the node(s) added
        :rtype: Flowchart

    .. php:method:: addSubGraph(SubGraph ...$subGraph)

        Add sub-graph(s)

        :param SubGraph ...$subGraph: The sub-graph(s)
        :returns: A new instance of ``Flowchart`` with the sub-graph(s) added
        :rtype: Flowchart

    .. php:method:: render(array $attributes = [])

        Renders the diagram

        :param array $attributes: HTML attributes for the <pre> tag as name=>value pairs

            .. note:: The *mermaid* class is added

        :returns: Mermaid diagram code in a <pre> tag
        :rtype: string

    .. php:method:: withComment(string $comment)

        Add a comment

        :param string $comment: The comment
        :returns: A new instance of ``Flowchart`` with the comment
        :rtype: Flowchart

    .. php:method:: withDirection(Direction $direction)

        Set the flowchart direction

        The default flowchart direction is :php:case:`Direction::TB`

        :param Direction $direction): The direction
        :returns: A new instance of ``Flowchart`` with the direction
        :rtype: Flowchart

    .. php:method:: withEdge(Edge ...$edge)

        Set edge(s)

        :param Edge ...$edge: The edge(s)
        :returns: A new instance of ``Flowchart`` with the edge(s)
        :rtype: Flowchart

    .. php:method:: withNode(Node ...$node)

        Set node(s)

        :param Node ...$node: The node(s)
        :returns: A new instance of ``Flowchart`` with the node(s)
        :rtype: Flowchart

    .. php:method:: withSubGraph(SubGraph ...$subGraph)

        Set sub-graph(s)

        :param SubGraph ...$subGraph: The sub-graph(s)
        :returns: A new instance of ``Flowchart`` with the sub-graph(s)
        :rtype: Flowchart

    .. php:method:: withTitle(string $title)

        Add a title

        :param string $title: The title
        :returns: A new instance of ``Flowchart`` with the title
        :rtype: Flowchart
