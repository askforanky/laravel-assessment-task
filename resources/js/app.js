// require('./bootstrap');
const toast = (flag = 0, msg = "", time = 2000) => {
    let backgroundColor = flag == 1 ? "#8dbf42" : "#e7515a";
    Snackbar.show({
        text: msg,
        actionTextColor: "#fff",
        backgroundColor,
        duration: time,
        showAction: false,
        pos: "top-right",
    });
};

const postRequest = (url, data, callback) => {
    $.ajax({
        type: "post",
        url,
        data,
        success: function (response) {
            callback(response);
        },
    });
};

const postForm = (url, form, callback) => {
    $.ajax({
        type: "post",
        url,
        data: $("#" + form).serialize(),
        success: function (response) {
            callback(response);
        },
    });
};
