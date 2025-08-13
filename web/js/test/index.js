class test {
    initialData = [];

    SELECTORS = {
        topics: '.topics',
        subtopics: '.sub-topics',
        description: '.description',
        topic: '.topic',
        subtopic: '.subtopic'
    };

    currentTopic = 0;
    currentSubtopic = 0;

    PARAMETERS = {
        topicid: 'topicid'
    };

    constructor() {
        this.initialData = [
            {
                id: 0,
                type: 'topic',
                name: 'Тема 1',
                subtopics: [
                    {
                        id: 0,
                        type: 'subtopic',
                        name: 'Подтема 1.1',
                        description: 'Некий текст, привязанный к Подтеме 1.1'
                    },
                    {
                        id: 1,
                        type: 'subtopic',
                        name: 'Подтема 1.2',
                        description: 'Некий текст, привязанный к Подтеме 1.2'
                    },
                    {
                        id: 2,
                        type: 'subtopic',
                        name: 'Подтема 1.3',
                        description: 'Некий текст, привязанный к Подтеме 1.3'
                    }
                ]
            },
            {
                id: 1,
                type: 'topic',
                name: 'Тема 2',
                subtopics: [
                    {
                        id: 3,
                        type: 'subtopic',
                        name: 'Подтема 2.1',
                        description: 'Некий текст, привязанный к Подтеме 2.1'
                    },
                    {
                        id: 4,
                        type: 'subtopic',
                        name: 'Подтема 2.2',
                        description: 'Некий текст, привязанный к Подтеме 2.2'
                    },
                    {
                        id: 5,
                        type: 'subtopic',
                        name: 'Подтема 2.3',
                        description: 'Некий текст, привязанный к Подтеме 2.3'
                    }
                ]
            }
        ];
    }

    init() {
        this.drawBlocks();

        $(document).on('click', this.SELECTORS.topic, function(event) {
            let target = $(event.target);

            this.currentTopic = parseInt(target.attr(this.PARAMETERS.topicid));
            this.currentSubtopic = this.initialData[this.currentTopic].subtopics[0].id;
            this.drawBlocks();
        }.bind(this));

        $(document).on('click', this.SELECTORS.subtopic, function(event) {
            let target = $(event.target);

            this.currentSubtopic = parseInt(target.attr(this.PARAMETERS.topicid));
            this.drawBlocks();
        }.bind(this));
    }

    drawBlocks() {
        let topicBox = $(this.SELECTORS.topics);
        topicBox.html('');

        this.initialData.forEach(function (topic, index) {
            topicBox.append(this.getElement(topic.name, topic.type, topic.id));

            if (this.isCurrentTopic(topic.id)) {
                let subtopicBox = $(this.SELECTORS.subtopics);
                subtopicBox.html('');

                let descriptionBox = $(this.SELECTORS.description);
                descriptionBox.html('');

                topic.subtopics.forEach(function (subtopic) {
                    subtopicBox.append(this.getElement(subtopic.name, subtopic.type, subtopic.id));

                    if (this.isCurrentSubtopic(subtopic.id)) {
                        descriptionBox.append(subtopic.description);
                    }

                }.bind(this));
            }
        }.bind(this));
    }

    getElement(elementHTML, elementClass, elementId) {
        return $('<div></div>', {html: elementHTML, 'class': elementClass, topicid: elementId});
    }

    isCurrentTopic(id) {
        return this.currentTopic === id;
    }

    isCurrentSubtopic(id) {
        return this.currentSubtopic === id;
    }
}

(new test()).init();