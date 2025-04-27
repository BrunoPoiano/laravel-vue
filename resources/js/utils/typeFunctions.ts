import { isObject } from "@vueuse/core";

export const isNumeric = (value: any): boolean => {
    return !Number.isNaN(Number.parseFloat(value)) && Number.isFinite(value);
};

export const isNumericString = (value: unknown): value is string => {
    return notEmptyString(value) && isNumeric(value);
};

export const IsNumberOrDefault = (value: unknown, defaultValue = 0): number => {
    if (typeof value === 'number') {
        return value;
    }
    if (typeof value === 'string') {
        const parsed = Number(value);
        if (!Number.isNaN(parsed)) {
            return parsed;
        }
    }
    return defaultValue;
};

export const isString = (value: unknown): value is string =>
    /* Checks if the value is a string */
    typeof value === 'string';

export const isNumber = (value: unknown): value is number =>
    /* Checks if the value is a number */
    typeof value === 'number';

export const notEmptyString = (value: unknown): value is string =>
    /* Checks if the value is a string and it's not empty */
    isString(value) && value.trim() !== '';

export const IsString = <T = null>(value: unknown, defaultValue = ''): string | T => {
    if (notEmptyString(value)) return value.trim();

    if (isNumber(value)) return value.toString();

    return defaultValue;
};

export const checkInertiaParamItemReturnsObject = <T = object>(item: unknown): T => {
    return (typeof item === 'object' && item !== null && 'data' in item && isObject(item.data) ? item.data : {}) as T;
}

export const checkInertiaParamItemReturnsArray = <T = object>(item: unknown): T[] => {
    return (typeof item === 'object' && item !== null && 'data' in item && Array.isArray(item.data) ? item.data : []) as T[];
}
