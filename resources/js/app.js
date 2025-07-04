import "./bootstrap";
import { createIcons, icons } from "lucide";
import Alpine from "alpinejs";
import AutoNumeric from "autonumeric";

window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    createIcons({ icons });
});

window.rupiahFormat = function (idElement) {
    new AutoNumeric(`#${idElement}`, {
        digitGroupSeparator: ".",
        decimalCharacter: ",",
        currencySymbol: "Rp ",
        currencySymbolPlacement: "p",
        minimumValue: "0",
        unformatOnSubmit: true,
    });
};
