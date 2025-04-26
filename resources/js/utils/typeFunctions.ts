export function IsNumberOrDefault(
	value: unknown,
	defaultValue: number,
): number {
    console.log(value)
	if (typeof value === "number") {
		return value;
	}

	if (!Number.isNaN(Number(value))) {
		return Number(value);
	}

	return defaultValue;
}

export function IsString(
	value: unknown,
): string {
	if (typeof value === "string") {
		return value;
	}
	return (value as string).toString();
}
