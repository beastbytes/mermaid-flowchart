Node Class
==========

.. php:class:: Node

    Represents a Node in a Flowchart diagram

    .. php:method:: __construct(NodeShape $shape = NodeShape::process, ?string $id = null)

        Creates a Node

        :param NodeShape $shape: The node shape (default: :php:case:`NodeShape::process`)
        :param ?string $id: The node id (default: auto-generate)
        :returns: A new instance of ``Node``
        :rtype: Node

    .. php:method:: withComment(string $comment)

        Add a comment

        :param string $comment: The comment
        :returns: A new instance of ``Node`` with the comment
        :rtype: Node

    .. php:method:: withInteraction(string $interaction, InteractionType $type, ?string $tooltip = null, InteractionTarget $target = InteractionTarget::Self)

        Add an interaction to the node

        :param string $interaction: The interaction, either a callback or URL
        :param InteractionType $type: The interaction type
        :param ?string $tooltip: A tooltip for the interaction
        :param InteractionTarget $target: The interaction target if $type === :php:case:`Interaction::Link` (default: InteractionTarget::Self)
        :returns: A new instance of ``Node`` with the interaction
        :rtype: Node

    .. php:method:: withStyleClass(string $styleClass)

        Set a style class for the node

        :param string $styleClass: The style class
        :returns: A new instance of ``Node`` with the style class
        :rtype: Node

    .. php:method:: withText(string $text)

        Add text to the node

        :param string $text: The text
        :returns: A new instance of ``Node`` with the text
        :rtype: Node
