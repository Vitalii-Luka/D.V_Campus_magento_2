/**
 * grunt exec:vitaliiluka_luma_uk_ua && grunt less:vitaliiluka_luma_uk_ua && grunt watch
 * grunt exec:vitaliiluka_luma_en_us && grunt less:vitaliiluka_luma_en_us && grunt watch
 */
module.exports = {
    vitaliiluka_luma_uk_ua: {
        area: 'frontend',
        name: 'VitaliiLuka/luma,
        locale: 'uk_UA',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    },
    vitaliiluka_luma_en_us: {
        area: 'frontend',
        name: 'VitaliiLuka/luma',
        locale: 'en_US',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    }
};
