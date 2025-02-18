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

        await this.pincode().fill(pincode);
        await this.chooseQuestion(question, answer);
        await this.savePincodeForm();
    }

    pincode(): Locator {
        return this.page.getByLabel('Enter pincode');
    }

    public async chooseQuestion(question: string, answer: string) {
        await this.theSecurityQuestionDropdown().selectOption(question);
        await this.answer().fill(answer);
    }

    public theSecurityQuestionDropdown(): Locator {
        return this.page.getByLabel('Choose question');
    }

    answer(): Locator {
        return this.page.getByLabel('Answer');
    }

    public async savePincodeForm() {
        await this.page.locator('button:has-text("Save")').click();
        await this.ensurePincodeWasUpdated();
    }

    public async disablePinUsingPincode(pincode: string) {
        this.loadPincodeForm();
        await this.pincode().fill(pincode);
        await this.savePincodeForm();
    }

    async ensurePincodeWasUpdated() {
        const successMessage = this.page.locator('.alert-success', { hasText: 'Pincode settings were updated' });
        await expect(successMessage).toBeVisible();
    }

    public async disablePinUsingAnswer(answer: string){
        this.loadPincodeForm();
        await this.answer().fill(answer);
        await this.savePincodeForm();
    }
}
