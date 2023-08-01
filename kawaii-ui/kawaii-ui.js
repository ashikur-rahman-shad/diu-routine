function importJS(src) {
    const scriptElement = document.createElement("script");
    scriptElement.src = src;
    document.body.appendChild(scriptElement);
}

function importCSS(src) {
    const linkElement = document.createElement("link");
    linkElement.rel = "stylesheet";
    linkElement.href = src;
    document.head.appendChild(linkElement);
}

function viewport() {
    const metaTag = document.createElement("meta");
    metaTag.setAttribute("name", "viewport");
    metaTag.setAttribute("content", "width=device-width, initial-scale=1.0");
    document.head.appendChild(metaTag);
}
document.addEventListener("DOMContentLoaded", function () {
    viewport();
    importCSS("./kawaii-ui/styles/kawaii.css");
    importJS("./kawaii-ui/scripts/kawaii.js");
});

async function fetchJSON(from) {
    try {
        const response = await fetch(from);
        const data = await response.json();
        return data;
    } catch (error) {
        console.log("Error: ", error);
        throw error; // Re-throw the error so it can be caught in the calling function if needed.
    }
}

async function fetchText(from) {
    try {
        const response = await fetch(from);
        const textData = await response.text();
        return textData;
    } catch (error) {
        console.log("Error: ", error);
        throw error; // Re-throw the error so it can be caught in the calling function if needed.
    }
}