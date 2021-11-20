export function createSelectNode(id, options = [], optionKey = 'id', optionTitle = 'title', value = null, required = true) {
    const formGroupDiv = document.createElement('div')
    formGroupDiv.setAttribute('class', 'form-group')

    const label = document.createElement('label')
    label.setAttribute('class', 'form-label')
    label.innerHTML = `#${id}`
    formGroupDiv.appendChild(label)

    const selectWrapperDiv = document.createElement('div')
    selectWrapperDiv.setAttribute('data-controller', 'select')

    const select = document.createElement('select')
    select.setAttribute('class', 'form-control')
    if (required) {
        select.setAttribute('required', 'required')
    }
    select.setAttribute('id', `data-word-select-${id}`)
    select.setAttribute('name', `data[words][#${id}]`)

    const option = document.createElement('option')
    select.appendChild(option)
    for (let i = 0; i < options.length; i++) {
        const option = document.createElement('option')
        option.setAttribute('value', options[i][optionKey])
        option.innerHTML = options[i][optionTitle]
        if (value && options[i][optionKey] === value) {
            option.setAttribute('selected', 'selected')
        }
        select.appendChild(option)
    }

    selectWrapperDiv.appendChild(select)
    formGroupDiv.appendChild(selectWrapperDiv)

    return formGroupDiv
}
