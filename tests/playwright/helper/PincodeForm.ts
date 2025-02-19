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
        await this.getForm().isVisible();
    }

    getForm(): Locator {
        return this.page.locator('#pincode-settings-form');
    }

    public async closePincodeForm() {
        await this.page.locator('button:has-text("Cancel")').click();
    }

    public async enablePin(pincode: string, question: string, answer: string) {
        this.loadPincodeForm();

        await this.fillPincode(pincode);
        await this.chooseQuestion(question, answer);
        await this.savePincodeFormSuccessfully();
    }

    public async fillPincode(pincode: string) {
        await this.pincode().fill(pincode);
    }

    public pincode(): Locator {
        return this.page.getByLabel('Enter pincode');
    }

    public async chooseQuestion(question: string, answer: string) {
        await this.theSecurityQuestionDropdown().selectOption(question);
        await this.fillAnswer(answer);
    }

    public theSecurityQuestionDropdown(): Locator {
        return this.page.getByLabel('Choose question');
    }

    public async fillOwnQuestion(ownQuestion) {
        await this.theSecurityQuestionDropdown().selectOption('Own question');
        await this.page.locator("input[name^='Client'][name$='[question]']").fill(ownQuestion);
    }

    public async fillAnswer(answer: string) {
        await this.page.getByLabel('Answer').fill(answer);
    }

    public async savePincodeFormSuccessfully() {
        await this.savePincodeFormWithMessage('Pincode settings were updated');
    }

    public async savePincodeFormWithMessage(message: string) {
        await this.clickSaveButton();
        await this.getForm().isHidden();
        await this.hasNotification(message);
        await this.closeNotification();
    }

    public async clickSaveButton() {
        await this.page.locator('button:has-text("Save")').click();
    }

    public async disablePinUsingPincode(pincode: string) {
        this.loadPincodeForm();
        await this.fillPincode(pincode);
        await this.savePincodeFormSuccessfully();
    }

    public async hasNotification(message: string) {
        const notification = this.notification();
        const successMessage = notification.locator('.alert', { hasText: message });
        await expect(successMessage).toBeVisible();
    }

    notification(): Locator {
        return this.page.locator('.ui-pnotify');
    }

    public async closeNotification() {
        const notification = this.notification();
        if (await notification.isVisible()) {
            await notification.hover();

            const closeButton = notification.locator('.ui-pnotify-closer');
            if (await closeButton.isVisible()) {
                await closeButton.click();
            }
        }
    }

    public async disablePinUsingAnswer(question: string, answer: string){
        this.loadPincodeForm();
        await this.page.getByRole('link', { name: 'Forgot pincode?' }).click();
        await this.page.getByLabel(question).fill(answer);
        await this.savePincodeFormSuccessfully();
    }
}
