// ConcreteCommands.js
class SearchSynonymCommand extends Command {
    constructor(receiver, word) {
        super();
        this.receiver = receiver;
        this.word = word;
    }

    execute() {
        return this.receiver.searchSynonym(this.word);
    }
}

class AddFillerWordCommand extends Command {
    constructor(receiver, word) {
        super();
        this.receiver = receiver;
        this.word = word;
    }

    execute() {
        return this.receiver.addFillerWord(this.word);
    }
}

class RemoveFillerWordCommand extends Command {
    constructor(receiver, word) {
        super();
        this.receiver = receiver;
        this.word = word;
    }

    execute() {
        return this.receiver.removeFillerWord(this.word);
    }
}
