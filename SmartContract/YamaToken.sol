// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

contract TokenControl {
    struct Token {
        uint256 totalSupply;
        mapping(address => uint256) balances;
        mapping(address => mapping(address => uint256)) allowances;
    }

    struct Member {
        bool exists;
        bool active;
    }
    
    Token public token;
    mapping(address => bool) public voters;
    
    event Transfer(address indexed from, address indexed to, uint256 value);
    event Approval(address indexed owner, address indexed spender, uint256 value);
    event Vote(address indexed voter, bool approve);
    event TokenChange(uint256 newSupply);

    constructor(uint256 initialSupply) {
        token.totalSupply = initialSupply;
        token.balances[msg.sender] = initialSupply;
        voters[msg.sender] = true;
    }

    mapping (address => Member) public members;
    address[] public membersList;
    uint public memberCount;

    struct Poll {
        string question;
        string[] options;
        mapping (uint => uint) votes;
        bool closed;
    }

    Poll[] public polls;
    uint public pollCount;

    modifier onlyMember {
        require(members[msg.sender].exists && members[msg.sender].active);
        _;
    }
    
    function transfer(address to, uint256 value) public returns (bool) {
        require(value <= token.balances[msg.sender], "Insufficient balance");
        token.balances[msg.sender] -= value;
        token.balances[to] += value;
        emit Transfer(msg.sender, to, value);
        return true;
    }
    
    function approve(address spender, uint256 value) public returns (bool) {
        token.allowances[msg.sender][spender] = value;
        emit Approval(msg.sender, spender, value);
        return true;
    }
    
    function transferFrom(address from, address to, uint256 value) public returns (bool) {
        require(value <= token.balances[from], "Insufficient balance");
        require(value <= token.allowances[from][msg.sender], "Insufficient allowance");
        token.balances[from] -= value;
        token.balances[to] += value;
        token.allowances[from][msg.sender] -= value;
        emit Transfer(from, to, value);
        return true;
    }
    
    function vote(bool approve) public {
        require(token.balances[msg.sender] > 0, "You don't have any token");
        require(!voters[msg.sender], "You already voted");
        voters[msg.sender] = true;
        emit Vote(msg.sender, approve);
    }
    
    function changeToken(uint256 newSupply) public {
        require(voters[msg.sender], "You haven't voted yet");
        uint256 approveCount = 0;
        uint256 rejectCount = 0;
        for (uint256 i = 0; i < token.totalSupply; i++) {
            address voter = address(i);
            if (voters[voter]) {
                if (token.balances[voter] > 0) {
                    approveCount += 1;
                } else {
                    rejectCount += 1;
                }
            }
        }
        if (approveCount > rejectCount) {
            token.totalSupply = newSupply;
            emit TokenChange(newSupply);
        }
    }

    function createDAO() public {
        require(!members[msg.sender].exists);
        members[msg.sender] = Member(true, true);
        membersList.push(msg.sender);
        memberCount++;
    }

    function joinDAO() public {
        require(!members[msg.sender].exists);
        members[msg.sender] = Member(true, true);
        membersList.push(msg.sender);
        memberCount++;
    }

    function leaveDAO() public onlyMember {
        members[msg.sender].exists = false;
        members[msg.sender].active = false;
        memberCount--;
    }

    function createPoll(string memory _question, string[] memory _options) public onlyMember {
        Poll memory newPoll = Poll({
            question: _question,
            options: _options,
            closed: false
        });
        polls.push(newPoll);
        pollCount++;
    }

    function vote(uint _pollIndex, uint _optionIndex) public onlyMember {
        require(!polls[_pollIndex].closed);
        require(_optionIndex < polls[_pollIndex].options.length);
        polls[_pollIndex].votes[_optionIndex]++;
    }

    function closePoll(uint _pollIndex) public onlyMember {
        require(!polls[_pollIndex].closed);
        polls[_pollIndex].closed = true;
    }
}