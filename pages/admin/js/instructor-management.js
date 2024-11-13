function updateDropdownBackground(selectElement) {
    const value = selectElement.value;
    const backgroundColors = {
        Status: "white", 
        Setuju: "lightgreen",
        Tolak: "lightcoral"
    };

    selectElement.style.backgroundColor = backgroundColors[value];
}



