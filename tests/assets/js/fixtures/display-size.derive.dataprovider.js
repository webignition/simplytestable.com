module.exports = {
    'lg matches': {
        'matchMediaMatches': {
            'xs': false,
            'sm': false,
            'md': false,
            'lg': true
        },
        'expectedDisplaySizeName': 'lg'
    },
    'md matches': {
        'matchMediaMatches': {
            'xs': false,
            'sm': false,
            'md': true,
            'lg': false
        },
        'expectedDisplaySizeName': 'md'
    },
    'sm matches': {
        'matchMediaMatches': {
            'xs': false,
            'sm': true,
            'md': false,
            'lg': false
        },
        'expectedDisplaySizeName': 'sm'
    },
    'xs matches': {
        'matchMediaMatches': {
            'xs': true,
            'sm': false,
            'md': false,
            'lg': false
        },
        'expectedDisplaySizeName': 'xs'
    }
};
