class Cookies
{
    static #instance = null;

    static getInstance()
    {
        return this.#instance ??= new Cookies();
    }

    constructor()
    {
        this.cookies = this.getCookiesAsMap();
    }

    getCookiesAsMap()
    {
        return document.cookie.split('; ').reduce((cookies, item) => {
            const [key, value] = item.split('=');
            cookies[key] = decodeURIComponent(value);
            return cookies;
        }, {});
    }

    findCookie(name)
    {
        return this.cookies[name] ?? this.getCookiesAsMap()[name];
    }

    addCookie(cookieName, cookieValue)
    {
        const expireDate = new Date();
        expireDate.setTime(expireDate.getTime() + 365 * (1000 * 86400));

        const cookieContent = `${cookieName}=${cookieValue};expires=${expireDate.toUTCString()}`;

        document.cookie = cookieContent;
        this.cookies = this.getCookiesAsMap();
    }
}