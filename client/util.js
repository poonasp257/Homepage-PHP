function getUrlParameter(parameterName) {
    const urlParameters = location.search.substring(1).split('&');
    
    for (let i = 0; i < urlParameters.length; ++i) {
        let parameter = urlParameters[i].split('=');

        if (parameter[0] === parameterName) {
            return parameter[1] == '' ? null : decodeURI(parameter[1]);
        }
    }

    return null;
};

function setUrlParameter(parameterName, value) {
    let urlParameters = location.search.substring(1).split('&');
    let newUrl = location.pathname + '?';

    for (let i = 0; i < urlParameters.length; ++i) {
        const parameter = urlParameters[i].split('=');
        if (parameter[0] == parameterName) {
            urlParameters[i] = parameterName + '=' + value;
        }
        
        newUrl += urlParameters[i];
        if (i < urlParameters.length - 1) newUrl += '&';
    }

    location.href = newUrl;
};

function createNewElement(tag, className = '', innerHTML = '') {
    if (!tag) return null;

    let newElement = document.createElement(tag);
    Object.assign(newElement, { className, innerHTML });
    return newElement;
}

function isToday(dateTime) {
    dateTime = dateTime.replace(" ", "T");
    const date = new Date(dateTime);
    const todayDate = new Date();

    return date.getFullYear() == todayDate.getFullYear()
        && date.getMonth() == todayDate.getMonth()
        && date.getDate() == todayDate.getDate();
}

function getDifferenceFromCurrentTime(dateTime) {
    dateTime = dateTime.replace(" ", "T");
    let inTime = new Date(dateTime);
    let nowTime = new Date();    
    return nowTime - inTime;
}

function getDateTimeStr(date) {
    const diffTime = getDifferenceFromCurrentTime(date);
    if (isToday(date)) {
        const hours = parseInt((diffTime / (1000 * 60 * 60)) % 24);
        const minutes = parseInt((diffTime / (1000 * 60)) % 60);

        return hours != 0 ? `${hours}시간 전` : `${minutes}분 전`;
    }
    
    return date.split(' ')[0];
}