import { expect, Page } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import Blacklist from "@hipanel-module-client/model/Blacklist";

export default class BlacklistHelper {
    private page: Page;
    private index: Index;

    public constructor(page: Page) {
        this.page = page;
        this.index = new Index(page);
    }

    async gotoIndexBlacklist(blackCategory: BlacklistCategoryInterface) {
        await this.page.goto('/client/' + blackCategory.getName()  + '/index');
        await expect(this.page).toHaveTitle(blackCategory.getLabel());
    }

    async gotoBlacklistPage(rowNumber: number) {
        await this.index.clickColumnOnTable('Name', rowNumber);
    }

    async checkDetailViewData(blacklist: Blacklist) {
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[1]/td')).toContainText(blacklist['name']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[2]/td')).toContainText(blacklist['message']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[3]/td')).toContainText(blacklist['showMessage']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[4]/td')).toContainText(blacklist['type']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[5]/td')).toContainText(blacklist['client']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[6]/td')).toContainText(blacklist['created']);
    }

    async fillBlacklistFromIndexPage(numberRow: number) {
        const index = new Index(this.page);

        let blacklist = new Blacklist();
        blacklist['name'] = await index.getValueInColumnByNumberRow('Name', numberRow);
        blacklist['type'] = await index.getValueInColumnByNumberRow('Type', numberRow);
        blacklist['message'] = await index.getValueInColumnByNumberRow('Message', numberRow);
        blacklist['showMessage'] = await index.getValueInColumnByNumberRow('Show message', numberRow);
        blacklist['client'] = await index.getValueInColumnByNumberRow('Client', numberRow);
        blacklist['created'] = await index.getValueInColumnByNumberRow('Created', numberRow);
        return blacklist;
    }

    async hasMainElementsOnIndexPage() {
        const indexPage = new Index(this.page);
        await indexPage.hasAdvancedSearchInputs([
            "BlacklistedSearch[name]",
            "BlacklistedSearch[types][]",
        ]);

        await indexPage.hasColumns(["Name", "Type", "Message", "Show message", "Client", "Created"]);
    }
}
