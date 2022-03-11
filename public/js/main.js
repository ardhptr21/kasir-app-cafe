function addUrlSearchParams(data) {
    const url = new URL(window.location.href);
    if (Array.isArray(data) && data.length > 0) {
        data.forEach((entry) => {
            if (entry.value === "") {
                url.searchParams.has(data.key) &&
                    url.searchParams.delete(data.key);
            }
            url.searchParams.set(entry.key, entry.value);
        });
    } else {
        if (data.value === "") {
            url.searchParams.has(data.key) && url.searchParams.delete(data.key);
        } else {
            url.searchParams.set(data.key, data.value);
        }
    }
    location.href = url.toString();
}

async function getServices(search, cb) {
    if (search == "") {
        cb();
        return [];
    }
    const url = `/services?service=${search}&type=json`;
    try {
        const res = await fetch(url);
        const data = await res.json();
        return data;
    } catch (err) {
        console.log(err);
    } finally {
        cb();
    }
}

function now() {
    const url = new URL(location.href);
    if (url.searchParams.get("search") == "day") {
        if (url.searchParams.has("date")) {
            return url.searchParams.get("date");
        }
    }

    let d = new Date(),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = "0" + month;
    if (day.length < 2) day = "0" + day;

    return [year, month, day].join("-");
}

function getParam(param) {
    const url = new URL(location.href);
    return url.searchParams.get(param);
}
