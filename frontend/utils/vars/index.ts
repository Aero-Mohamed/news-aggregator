const protocol = process.env.NEXT_PUBLIC_PROTOCOL || "";

export const vars = {
    isProduction: (process.env.NODE_ENV || "")?.trim() === "production",
    isTesting: (process.env.NODE_ENV || "")?.trim() === "test",
    isDevelopment: (process.env.NODE_ENV || "")?.trim() === "development",

    app: {
        protocol,
        baseUrl: `${protocol}://${process.env.NEXT_PUBLIC_BASE_URL}/api`,
    },
    api: { headers: { accept: "application/json", "content-type": "application/json" } },
}

export default vars;
