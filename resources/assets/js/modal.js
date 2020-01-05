import $ from "jquery";

setTimeout(() => {
        const positive = $('#positive').text()
        const negative = $('#negative').text()
        const number = $('#telephone').text()

        const phones = JSON.parse(localStorage.phones || '{}')

        if (!phones[number]) {
            const modal = $('#myModal')

            modal.modal('show').delay(500)

            $('.btn').click(() => modal.modal('hide').delay(500))

            phones[number] = 1

            localStorage.phones = JSON.stringify(phones)
        }
    },
    8000
)