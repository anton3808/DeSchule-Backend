export default {
    props: {
        dom: {
            type: String,
            default: () => ''
        },
        data: {
            type: Object,
            default: () => ({})
        }
    },
}
