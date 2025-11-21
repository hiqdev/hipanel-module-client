export default class WhitelistCategory implements BlacklistCategoryInterface {
  getName(): string {
    return "whitelist";
  }

  getLabel(): string {
    return "Whitelist";
  }
}
