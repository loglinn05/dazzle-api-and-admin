import { defineStore } from "pinia";
import { useToast } from "primevue/usetoast";

export const useHelpersStore = defineStore("helpers", () => {
    const toast = useToast();

    function toSentenceCase(string) {
        return string
            .replace(/^[-_]*(.)/, (_, char) => char.toUpperCase())
            .replace(/[-_]+(.)/g, (_, char) => " " + char)
            .replace(/id/i, "ID");
    }

    function formatCurrency(value) {
        return value.toLocaleString("en-US", {
            style: "currency",
            currency: "USD",
        });
    }

    function isObject(object) {
        return (
            typeof object === "object" &&
            !Array.isArray(object) &&
            object !== null
        );
    }

    function isEmptyObject(object) {
        for (const prop in object) {
            if (Object.hasOwn(object, prop)) {
                return false;
            }
        }

        return true;
    }

    function isBoolean(bool) {
        return typeof bool === "boolean";
    }

    function getFileExtension(filename) {
        return filename.substring(
            filename.lastIndexOf(".") + 1,
            filename.length
        );
    }

    function displayValidationErrors(errors) {
        for (let key in errors) {
            errors[key].forEach((error) => {
                toast.add({
                    severity: "error",
                    summary: error,
                    life: 5000,
                });
            });
        }
    }

    function handleError(error) {
        if (error.response.data.errors) {
            displayValidationErrors(error.response.data.errors);
        } else {
            console.error(error);
        }
    }

    return {
        toSentenceCase,
        formatCurrency,
        isObject,
        isEmptyObject,
        isBoolean,
        getFileExtension,
        displayValidationErrors,
        handleError,
    };
});
