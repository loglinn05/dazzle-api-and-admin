export function toSentenceCase(string) {
    return string
        .replace(/^[-_]*(.)/, (_, char) => char.toUpperCase())
        .replace(/[-_]+(.)/g, (_, char) => " " + char)
        .replace(/id/i, "ID");
}

export function formatCurrency(value) {
    return value.toLocaleString("en-US", {
        style: "currency",
        currency: "USD",
    });
}

export function isObject(object) {
    return (
        typeof object === "object" && !Array.isArray(object) && object !== null
    );
}

export function isEmptyObject(object) {
    for (const prop in object) {
        if (Object.hasOwn(object, prop)) {
            return false;
        }
    }

    return true;
}

export function isBoolean(bool) {
    return typeof bool === "boolean";
}

export function getFileExtension(filename) {
    return filename.substring(filename.lastIndexOf(".") + 1, filename.length);
}
