import { expect, Page } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import Blacklist from "@hipanel-module-client/model/Blacklist";
import BlacklistForm from "@hipanel-module-client/page/BlacklistForm";
import BlacklistView from "@hipanel-module-client/page/BlacklistView";
import Alert from "@hipanel-core/ui/Alert";

export default class BlacklistHelper {
    private page: Page;
    private index: Index;
    private blackCategory: BlacklistCategoryInterface;

    public constructor(page: Page, blackCategory: BlacklistCategoryInterface) {
        this.page = page;
        this.index = new Index(page);
        this.blackCategory = blackCategory;
    }

    async gotoIndexBlacklist() {
        await this.page.goto('/client/' + this.blackCategory.getName()  + '/index');
        await expect(this.page).toHaveTitle(this.blackCategory.getLabel());
    }

    async gotoBlacklistPage(rowNumber: number) {
        await this.index.clickColumnOnTable('Name', rowNumber);
    }

    async checkDetailViewData(blacklist: Blacklist) {
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[1]/td')).toContainText(blacklist['name']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[2]/td')).toContainText(blacklist['message']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[3]/td')).toContainText(blacklist['showMessage']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[4]/td')).toContainText(blacklist['type']);

        if (blacklist['client'].length > 0) {
            await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[5]/td')).toContainText(blacklist['client']);
        }

        if (blacklist['created'].length > 0) {
            await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[6]/td')).toContainText(blacklist['created']);
        }
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

    async createBlacklist(blackCategory: BlacklistCategoryInterface, blacklist: Blacklist) {
        await this.gotoCreateBlacklist();

        const form = new BlacklistForm(this.page, blackCategory);
        await form.fill(blacklist);
        await form.create();
        await form.seeSuccessBlacklistCreatingAlert();

        return await form.getSavedBlacklistId();
    }

    async gotoCreateBlacklist() {
        await this.page.goto('/client/' + this.blackCategory.getName()  + '/create');
        await expect(this.page).toHaveTitle('Create ' + this.blackCategory.getLabel() + ' item');
    }

    async updateBlacklist() {

    }

    async deleteBlacklist(id: string) {
        const viewPage = await new BlacklistView(this.page, this.blackCategory);
        await viewPage.gotoViewBlacklist(id);
        await viewPage.detailMenuItem("Delete").click();
        await viewPage.acceptDeleteDialog();
        await Alert.on(this.page).hasText(this.blackCategory.getLabel() + "(s) were deleted");
    }
}
