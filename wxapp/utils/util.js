var formatTime = function(t) {
    var e = t.getFullYear(), r = t.getMonth() + 1, o = t.getDate(), i = t.getHours(), m = t.getMinutes(), n = t.getSeconds();
    return [ e, r, o ].map(formatNumber).join("/") + " " + [ i, m, n ].map(formatNumber).join(":");
}, formatNumber = function(t) {
    return (t = t.toString())[1] ? t : "0" + t;
}, toFix = function(t) {
    return t = t.toFixed();
};

module.exports = {
    formatTime: formatTime,
    toFix: toFix
};