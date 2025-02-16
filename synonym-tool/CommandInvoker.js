// CommandInvoker.js
class CommandInvoker {
    constructor() {
        this.commands = [];
    }

    addCommand(command) {
        this.commands.push(command);
    }

    executeCommand(command) {
        command.execute();
    }
}
