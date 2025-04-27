export function debounce<T extends (...args: T[]) => void>(func: T, delay = 300) {
    let timeout: ReturnType<typeof setTimeout> | null = null;
    return (...args: Parameters<T>): void => {
        if (timeout !== null) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(() => func(...args), delay);
    };
}
