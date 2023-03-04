document.getElementById("sizeX").onchange = function() { addInput() };
document.getElementById("sizeY").onchange = function() { addInput() };

function addInput()
{
    let sizeX =document.getElementById('sizeX').value;
    let sizeY =document.getElementById('sizeY').value;

    let container = document.getElementById('cells');
    container.innerHTML = "";

    let table = document.createElement('table');

    for (let i = 0; i < sizeX; i++) {
        let row = document.createElement('tr');
        for (let j = 0; j < sizeY; j++) {
            let input = document.createElement('input');
            input.type = 'number';
            input.name = 'cell' + i + j;
            input.style.width = '30px';
            input.value = '0';
            let cell = document.createElement('th');
            cell.append(input);
            row.appendChild(cell);
        }
        table.appendChild(row);
    }
    container.appendChild(table);
}
window.onload = addInput;
