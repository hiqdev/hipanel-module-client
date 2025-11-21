import { test } from "@hipanel-core/fixtures";
import Index from "@hipanel-core/page/Index";
import ClientView from "@hipanel-module-client/page/ClientView";

const visibleModalElements = [
  { "text": "Enter comma separated list of IP-addresses or subnets. Example: 88.208.52.222, 213.174.0.0/16 Your current IP address is" },
  {
    "text": "All of accounts in the hosting panel will use following permit IP addresses list by default. " +
      "You can reassign permitted IP addresses for each account individually in it's settings.",
  },
  { "text": "Allowed IPs for panel login" },
  { "text": "Default allowed IPs for SSH/FTP accounts" },
  { "text": "Save" },
  { "text": "Cancel" },
];

export type InputValue = {
  fieldName: string,
  text: string,
  errorMessage?: string
}
const invalidInputValues: Array<InputValue> = [
  {
    fieldName: "allowed_ips",
    text: "text",
    errorMessage: "Allowed IPs for panel login must be a valid IP address.",
  },
  {
    fieldName: "sshftp_ips",
    text: "text",
    errorMessage: "Default allowed IPs for SSH/FTP accounts must be a valid IP address.",
  },
  {
    fieldName: "allowed_ips",
    text: "255.255.255.255/33",
    errorMessage: "Allowed IPs for panel login contains wrong subnet mask.",
  },
  {
    fieldName: "sshftp_ips",
    text: "255.255.255.255/33",
    errorMessage: "Default allowed IPs for SSH/FTP accounts contains wrong subnet mask.",
  },
];

const validInputValues = [
  {
    allowedIpsField: "1.2.3.4",
    sshFtpIpsField: "1.2.3.4",
  },
  {
    allowedIpsField: "172.20.10.1",
    sshFtpIpsField: "172.20.10.1",
  },
  {
    allowedIpsField: "192.168.1.99/24",
    sshFtpIpsField: "192.168.1.99/24",
  },
  {
    allowedIpsField: "192.168.1.99/24",
    sshFtpIpsField: "",
  },
  {
    allowedIpsField: "",
    sshFtpIpsField: "192.168.1.99/24",
  },
  {
    allowedIpsField: "",
    sshFtpIpsField: "",
  },
];

test.describe("IP address restrictions @hipanel-module-client @admin", () => {

  let clientViewPage: ClientView;
  let indexPage: Index;
  let userId: string;

  test.beforeEach(async ({ adminPage }) => {
    clientViewPage = new ClientView(adminPage);
    indexPage = new Index(adminPage);

    userId = await indexPage.getAuthenticatedUserId();
    await clientViewPage.gotoClientView(userId, "hipanel_test_admin");
    await adminPage.locator("a:has-text(\"IP address restrictions\")").click();
  });

  test("Visible modal elements @hipanel-module-client @admin", async ({ adminPage }) => {
    await clientViewPage.checkVisibleModalRestrictElements(visibleModalElements);
  });

  // Other tests not applicable for Nope service

  // test("Invalid inputs @hipanel-module-client @admin", async ({ adminPage }) => {
  //     for(let i = 0; i < invalidInputValues.length; i++) {
  //         await clientViewPage.checkErrorModalRestrictInputValue(invalidInputValues[i], userId);
  //     }
  // });

  // validInputValues.forEach((inputValue) => {
  //     test(`Valid inputs "${inputValue.allowedIpsField}" "${inputValue.sshFtpIpsField}" @hipanel-module-client @admin`, async ({ adminPage }) => {
  //         await clientViewPage.fillFormModalRestrictValidInputValue(inputValue, userId);
  //         await adminPage.locator('button:has-text("Save")').click();
  //
  //         await Alert.on(adminPage).hasText('Settings saved');
  //
  //         await adminPage.locator('a:has-text("IP address restrictions")').click();
  //         await clientViewPage.checkFormModalRestrictInputValue(inputValue, userId);
  //     });
  // });

});
