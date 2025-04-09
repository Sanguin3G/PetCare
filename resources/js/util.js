const UrlApi = "/api/admin/";
export const Delete = async function (path, data) {
    const result = await $.ajax({
        type: "DELETE",
        url: UrlApi + path,
        data: data,
        headers: {
            Authorization:
                "Bearer " + localStorage.getItem("authTokenPassport"),
        },
    });
    return result;
};
export const Create = async function (path, data) {
    const result = await $.ajax({
        type: "POST",
        url: UrlApi + path,
        data: data,
        headers: {
            Authorization:
                "Bearer " + localStorage.getItem("authTokenPassport"),
        },
    });
    return result;
};
export const Get = async function (path, data) {
    const result = await $.ajax({
        type: "GET",
        url: UrlApi + path,
        data: data,
        headers: {
            Authorization:
                "Bearer " + localStorage.getItem("authTokenPassport"),
        },
    });
    return result;
};
export const Update = async function (path, data) {
    const result = await $.ajax({
        type: "PATCH",
        url: UrlApi + path,
        data: data,
        headers: {
            Authorization:
                "Bearer " + localStorage.getItem("authTokenPassport"),
        },
    });
    return result;
};
