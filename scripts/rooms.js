const daysOfWeek = [
    "Today",
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Saturday",
];

var slot_rooms_api_url = "./api/slot-rooms?";
var containerDiv, courseCode, batchclassType;

function RoomBookPage(parms) {
    containerDiv = document.getElementById(parms.container);
    courseCode = parms.courseCode;
    batch = parms.batch;
    classType = parms.classType;
    {
        const title = document.createElement("h1");
        title.textContent = classType + " Class";
        containerDiv.appendChild(title);
    }
    {
        const title2 = document.createElement("h3");
        title2.textContent = "Course: " + courseCode + ", Batch: " + batch;
        containerDiv.appendChild(title2);
    }
    {
        const dayDiv = document.createElement("div");
        dayDiv.id = "day-container";
        dayDiv.innerHTML = "<h4>Select Day</h4>";
        containerDiv.appendChild(dayDiv);
        let x = parms;
        x.dayContainer = "day-container";
        x.slotContainer = "slots";
        x.roomContainer = "rooms";
        x.messageContainer    = "message-div";
        createButtonsForDays(x);
    }
    {
        const slotdiv = document.createElement("div");
        slotdiv.id = "slots";
        containerDiv.appendChild(slotdiv);
    }
    {
        const roomDiv = document.createElement("div");
        roomDiv.id = "rooms";
        containerDiv.appendChild(roomDiv);
    }
    {
        const messageDiv = document.createElement("div");
        messageDiv.id = "message-div";
        containerDiv.appendChild(messageDiv);
    }
}

//

//

function createButtonsForDays(parms) {
    dayContainer = document.getElementById(parms.dayContainer);
    
    for (let i = 0; i < daysOfWeek.length; i++) {
        let day = daysOfWeek[i];

        let button = document.createElement("button");

        button.textContent = day;
        button.setAttribute(
            "onclick",
            `showSlots(${JSON.stringify(parms)}, '${day.toUpperCase()}')`
        );

        dayContainer.appendChild(button);
    }
}

//

//

async function showSlots(parms, day) {
    let roomContainer = document.getElementById(parms.roomContainer);
    if (roomContainer) roomContainer.innerHTML = "";

    let slotContainer = document.getElementById(parms.slotContainer);
    let courseTeacher = parms.teacher;
    let x = parms;
    x.day = day;
    let query =
        slot_rooms_api_url +
        `day=${day}&teacher=${courseTeacher}&batch=${batch}&course=${courseCode}`;
    jsonData = await fetchJSON(query);

    slotContainer.innerHTML = "<h4>Available Slots</h4>";
    for (let i = 0; i < jsonData.length; i++) {
        let slot = jsonData[i];

        let button = document.createElement("button");

        button.textContent = slot.start + " - " + slot.end;
        button.setAttribute(
            "onclick",
            `showRooms(${JSON.stringify(x)}, ${JSON.stringify(slot)})`
        );

        slotContainer.appendChild(button);
        slotContainer.innerHTML += ",";
    }
}

async function showRooms(parms, slot) {
    let roomContainer = document.getElementById(parms.roomContainer);
    let x = parms;
    x.slot = slot;

    let query = slot_rooms_api_url + `day=${parms.day}&slot=${slot.slot}`;

    jsonData = await fetchJSON(query);

    roomContainer.innerHTML = "<h4>Available Rooms</h4>";
    for (let i = 0; i < jsonData.length; i++) {
        let room = jsonData[i];

        let button = document.createElement("button");
        button.textContent = room.room;
        x.room = room.room;
        button.setAttribute(
            "onclick",
            `confirmReservation(${JSON.stringify(x)})`
        );

        roomContainer.appendChild(button);
        roomContainer.innerHTML += ",";
    }
}

async function confirmReservation(parms) {
    courseCode = parms.courseCode;
    batch = parms.batch;
    classType = parms.classType;
    let booking =
        bookingURL +
        "batch=" +
        parms.batch +
        "&course=" +
        parms.courseCode +
        "&day=" +
        parms.day +
        "&slot=" +
        parms.slot.slot +
        "&room=" +
        parms.room +
        "&classtype=" +
        parms.classType;
    let apiResult = await fetchJSON(booking);
    if(apiResult.message=="booked"){
        document.getElementById(parms.dayContainer).innerHTML = "";
        document.getElementById(parms.slotContainer).innerHTML = "";
        document.getElementById(parms.roomContainer).innerHTML = "";
        let output =`${parms.classType} class of ${parms.courseCode} - batch ${parms.batch} will be taken on ${parms.day}, ${apiResult.date}, from ${parms.slot.start} to ${parms.slot.end} by ${teacher}.`;
        document.getElementById(parms.messageContainer).innerHTML = output;
        
        loadRoutine();
        navigator.clipboard.writeText(output);

    }
    else{
        document.getElementById(parms.messageContainer).innerHTML = apiResult.message;
    }
}
