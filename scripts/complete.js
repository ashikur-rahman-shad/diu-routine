//importJS("./scripts/rooms.js");
var view;
var jsonData;
var query = "";
let data_link = "";
var view="";
var teacher;

const url = "./api/data.php?";
const bookingURL = "./api/book.php?";
const input = document.getElementById("data");
const section = document.getElementById("section");
const routineTable = document.getElementById("class-routine");

async function loadRoutine() {
    teacher = await fetchText("./api/teacher.php");

    if (query == "teacher") data_link = url + "teacher=" + teacher;
    else data_link = query;

    jsonData = await fetchJSON(data_link);
    document.getElementById("class-routine").innerHTML 
    = await createTable(jsonData);
}

function createTableRow(day, slots) {
    let row = "<tr><th>" + day + "</th>";

    // Group courses by day and slot
    let groupedCourses = {};
    slots.forEach((course) => {
        const key = course.day + "_" + course.slot;
        if (!groupedCourses.hasOwnProperty(key)) {
            groupedCourses[key] = [];
        }
        groupedCourses[key].push(course);
    });

    for (let i = 1; i <= 9; i++) {
        const key = day + "_" + i;
        let courses = groupedCourses[key];
        if (courses) {
            row += "<td>";
            row += courses
                .map((course) => {
                    let courseInfo = "";
                    if (course.date) {
                        courseInfo += `<mark>${course.classtype.toUpperCase()} CLASS </mark><br>`;
                    }
                    courseInfo += `${course.course} `;
                    if (view == "s") courseInfo += `<br> ${course.teacher}`;
                    else courseInfo += `<br>${course.batch}`;
                    courseInfo += `<br>  (${course.room})`;
                    if (course.date) {
                        courseInfo += `<br>${course.date}`;
                        if (course.teacher == teacher) {
                            courseInfo += `<br><a onclick="cancel('${courseInfo.day}','${courseInfo.slot}','${courseInfo.room}')">Cancel</a>`;
                        }
                    } else if (course.teacher == teacher) {
                        courseInfo += `
                                    <br>
                                    <a onclick="book(
                                        {classType:'Makeup', courseCode:'${course.course}', batch:'${course.batch}', teacher: '${course.teacher}'}
                                        )"> Makeup</a>
                                    / 
                                    <a onclick="book(
                                        {classType:'Extra', courseCode:'${course.course}', batch:'${course.batch}', teacher: '${course.teacher}'}
                                        )"> Extra class</a>
                                    `;
                    }
                    return courseInfo;
                })
                .join("<hr>");
            row += "</td>";
        } else {
            row += "<td></td>";
        }
    }
    row += "</tr>";
    return row;
}

function groupByDay(dataArray) {
    let groupedData = {};
    dataArray.forEach((course) => {
        if (!groupedData.hasOwnProperty(course.day)) {
            groupedData[course.day] = [];
        }
        groupedData[course.day].push(course);
    });
    return groupedData;
}

async function createTable(dataArray, data_link) {
    const groupedData = groupByDay(dataArray);
    var slotsData = await fetchJSON("./api/slot-rooms/?slots");

    let table = "<table><thead><tr><th>Days/Slots</th>";

    slotsData.forEach((element) => {
        table += `<th>${element.start} - ${element.end}</th>`;
    });

    table += "</tr></thead><tbody>";

    for (const [day, slots] of Object.entries(groupedData)) {
        table += createTableRow(day, slots);
    }

    table += "</tbody></table>";
    return table;
}

function cancel(day, slot, room) {
    fetch(cancelURL + "day=" + day + "&slot=" + slot + "&room=" + room)
        .then((response) => response.text())
        .then((result) => {
            alert(result);
            loadRoutine();
        })
        .catch((error) => {
            alert("Error:" + error);
        });
}
async function book(selection) {
    submission = selection;
    submission.container = "booking-popup";
    popupShow();
    RoomBookPage(submission);
}
