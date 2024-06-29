import moment from "moment"

export default {
    convertDateTime(date, time) {
        return moment(`${date} ${time}`).format('DD MMMM YYYY HH:mm')
    },
    paginationIt(index, pagination) {
        return (pagination.currentPage - 1) * pagination.perPage + index + 1;
    },
}
