import {expect, Locator, Page} from "@playwright/test";
import ClientView from "@hipanel-module-client/page/ClientView";

export default class PincodeForm {
    private page: Page;
    private view: ClientView;

    public constructor(page: Page, view: ClientView) {
        this.page = page;
        this.view = view;
    }

    public async loadPincodeForm() {
        await this.view.detailMenuItem("Pincode settings").click();
        await this.page.waitForSelector("#pincode-settings-form");
    }

    public async disablePin(page: Page) {
        this.loadPincodeForm();

        // Click the "Disable Pincode" button inside the modal
        const disableButton = page.getByRole('button', { name: 'Disable Pincode' });
        await disableButton.click();

        // Confirm the action if a confirmation popup appears
        const confirmButton = page.getByRole('button', { name: 'OK' });
        if (await confirmButton.isVisible()) {
            await confirmButton.click();
        }

        // Verify that the Pincode has been disabled (adjust selector if needed)
        const successMessage = page.locator('.alert-success', { hasText: 'Pincode disabled' });
        await expect(successMessage).toBeVisible();
    }

    public async closePincodeForm() {
        await this.page.locator('button:has-text("Cancel")').click();
    }

    public async savePincodeForm() {
        await this.page.locator('button:has-text("Save")').click();
        await expect(this.page.locator('text=Pincode settings were updated')).toBeVisible();
    }

    public async enablePin() {
        this.loadPincodeForm();
    }

    public async chooseQuestion(question: string, answer: string) {
        await this.openTheSecurityQuestionDropdown();

        // Select the provided question
        await this.page.getByRole('option', { name: question }).click();

        // Fill in the answer
        await this.page.locator('input[name="securityAnswer"]').fill(answer);
    }


    public async openTheSecurityQuestionDropdown() {
        await this.theSecurityQuestionDropdown().click();
    }

    public theSecurityQuestionDropdown(): Locator {
        return this.page.getByLabel('Choose question');
    }
}