const displaySize = {
    'derive': function () {
        const displayClassIds = ['lg', 'md', 'sm', 'xs'];
        let currentDisplayClassId = null;

        displayClassIds.forEach(function (displayClassId) {
            const current = document.getElementById(displayClassId);
            const displayStyle = window.getComputedStyle(current, null).display;

            if (displayStyle !== 'none') {
                currentDisplayClassId = displayClassId;
            }
        });

        return currentDisplayClassId;
    },
    'set': function (sizeName) {
        document.body.dataset.displaySizeName = sizeName;
    },
    'get': function () {
        return document.body.dataset.displaySizeName;
    }
};

module.exports = displaySize;
