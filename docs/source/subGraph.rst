SubGraph Class
==============

.. php:class:: SubGraph

    Represents a SubGraph

    .. php:method:: __construct(?string $title = null, ?string $id = null)

        Creates SubGraph

    .. php:method:: addEdge(Edge ...$edge)

        Add edge(s)

        :param Edge ...$edge: The edge(s)
        :returns: A new instance of ``SubGraph`` with the edge(s) added
        :rtype: SubGraph

    .. php:method:: addNode(Node ...$node)

        Add node(s)

        :param Node ...$node: The node(s)
        :returns: A new instance of ``SubGraph`` with the node(s) added
        :rtype: SubGraph

    .. php:method:: addSubGraph(SubGraph ...$subGraph)

        Add subgraph(s)

        :param SubGraph ...$subGraph: The subgraph(s)
        :returns: A new instance of ``SubGraph`` with the sub-graph(s) added
        :rtype: SubGraph

    .. php:method:: withComment(string $comment)

        Add a comment

        :param string $comment: The comment
        :returns: A new instance of ``SubGraph`` with the comment
        :rtype: SubGraph

    .. php:method:: withDirection(Direction $direction)

        Set the subgraph direction

        The default subgraph direction is :php:case:`Direction::TB`

        .. note::

            If any of the subgraph's nodes link outside of the subgraph,
            the subgraph direction is ignored and the subgraph inherits the direction of the parent graph.

        :param Direction $direction): The direction
        :returns: A new instance of ``SubGraph`` with the direction
        :rtype: SubGraph

    .. php:method:: withEdge(Edge ...$edge)

        Set edge(s)

        :param Edge ...$edge: The edge(s)
        :returns: A new instance of ``SubGraph`` with the edge(s)
        :rtype: SubGraph

    .. php:method:: withNode(Node ...$node)

        Set node(s)

        :param Node ...$node: The node(s)
        :returns: A new instance of ``SubGraph`` with the node(s)
        :rtype: SubGraph

    .. php:method:: withSubGraph(SubGraph ...$subGraph)

        Set sub-graph(s)

        :param SubGraph ...$subGraph: The sub-graph(s)
        :returns: A new instance of ``SubGraph`` with the sub-graph(s)
        :rtype: SubGraph
