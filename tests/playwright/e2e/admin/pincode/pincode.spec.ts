import {getUserId, test} from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import ClientView from "@hipanel-module-client/page/ClientView";

test.describe('Pincode Settings', () => {
    let pincodeForm;

    test.beforeEach(async ({ adminPage }) => {
        const clientViewPage = new ClientView(adminPage);
        const userId = getUserId('admin');
        await clientViewPage.gotoClientView(userId, 'hipanel_test_admin');
        pincodeForm = clientViewPage.getPincodeForm();
    });

    test('Check Pnotify Errors @hipanel-module-client @admin', async ({ page }) => {
        const testCases = [
            { pin: '', answer: 'test answer', message: 'no data given', ownQuestion: null },
            { pin: '1234', answer: '', message: 'wrong input: Answer', ownQuestion: null },
            { pin: '1234', answer: 'test answer', message: 'wrong input: Question', ownQuestion: '' },
        ];

        for (const { pin, answer, message, ownQuestion } of testCases) {
            await pincodeForm.loadPincodeForm();
            await pincodeForm.fillPincode(pin);
            await pincodeForm.fillAnswer(answer);

            if (ownQuestion !== null) {
                await pincodeForm.fillOwnQuestion(ownQuestion);
            }

            await pincodeForm.savePincodeFormWithMessage(message);
        }
    });

    test('Test PIN input validation @hipanel-module-client @admin', async ({ page }) => {
        await page.click('text=Pincode settings');

        const testCases = [
            { pin: '123', message: 'Enter pincode should contain at least 4 characters.' },
            { pin: '12345', message: 'Enter pincode should contain at most 4 characters.' },
        ];

        for (const { pin, message } of testCases) {
            await page.fill("[name='Client[123][pincode]']", pin);
            await page.click('text=Save');
            await expect(page.locator(`text=${message}`)).toBeVisible();
        }
    });

    test('Enable and disable PIN @hipanel-module-client @admin', async ({ page }) => {
        await page.click('text=Pincode settings');

        await page.fill("[name='Client[123][pincode]']", '1234');
        await page.fill("[name='Client[123][answer]']", 'test answer');
        await page.click('text=Save');
        await expect(page.locator('text=Pincode settings were updated')).toBeVisible();
    });
});
