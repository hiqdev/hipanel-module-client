import {Locator, Page} from "@playwright/test";

export default class BlacklistView {
    private page: Page;
    private blackCategory: BlacklistCategoryInterface;
    private detailMenuFunctionsLocator: Locator;

    public constructor(page: Page, blackCategory: BlacklistCategoryInterface) {
        this.page = page;
        this.blackCategory = blackCategory;
        this.detailMenuFunctionsLocator = page.locator(".profile-usermenu .nav");
    }

    async gotoViewBlacklist(id: string) {
        await this.page.goto(`/client/${this.blackCategory.getName()}/view?id=${id}`);
    }

    detailMenuItem(item: string): Locator {
        return this.detailMenuFunctionsLocator.locator(`:scope a:text("${item}")`);
    }

    async acceptDeleteDialog() {
        await this.page.waitForSelector('.modal-dialog');

        const deleteButton = await this.page.waitForSelector('.modal-dialog input[type="submit"][value="Delete"]');
        if (deleteButton) {
            await deleteButton.click();
        }
    }
}