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
    /* Verifica se o tipo é uma string */
    typeof value === 'string';

export const isNumber = (value: unknown): value is number =>
    /* Verifica se o tipo é um número */
    typeof value === 'number';

export const notEmptyString = (value: unknown): value is string =>
    /* Verifica se o tipo é uma string e se ela não está vazia */
    isString(value) && value.trim() !== '';

export const IsString = <T = null>(value: unknown, defaultValue = ''): string | T => {
    if (notEmptyString(value)) return value.trim();

    if (isNumber(value)) return value.toString();

    return defaultValue;
};
