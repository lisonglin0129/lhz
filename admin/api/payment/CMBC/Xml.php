<?php
$xmltx1111=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
	<Head>
		<TxCode>1111</TxCode>
	</Head>
	<Body>
		<InstitutionID/>
		<PaymentNo/>
		<Amount/>
		<Fee/>
		<PayerID/>
		<PayerName/>
		<SettlementFlag/>
		<Usage/>
		<Remark/>
		<NotificationURL/>
		<BankID/>
		<AccountType/>
	</Body>
</Request>
XML;

$xmltx1112=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
	<Head>
		<TxCode>1112</TxCode>
	</Head>
	<Body>
		<InstitutionID/>
		<PaymentNo/>
		<Amount/>
		<PayerID/>
		<PayerName/>
		<SettlementFlag/>
		<Usage/>
		<Remark/>
		<NotificationURL/>
	</Body>
</Request>
XML;

$xmltx1118=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1118</TxCode>
  </Head>
  <Body>
    <InstitutionID/>
    <PaymentNo/>
	<Amount/>
	<Status/>
	<BankNotificationTime/>
  </Body>
</Request>
XML;

$xmltx1120=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1120</TxCode>
  </Head>
  <Body>
    <InstitutionID/>
    <PaymentNo/>
  </Body>
</Request>
XML;

$xmltx1121=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1121</TxCode>
  </Head>
  <Body>
    <InstitutionID/>
    <PaymentNo/>
   </Body>
</Request>
XML;

$xmltx1131=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1131</TxCode>
  </Head>
  <Body>
    <InstitutionID/>
	<SerialNumber/>
    <PaymentNo/>
	<Amount/>
	<Remark/>
	<AccountType/>
	<PaymentAccountName/>
	<PaymentAccountNumber/>
	<BankAccount>
		<BankID/>
		<AccountName/>
		<AccountNumber/>
		<BranchName/>
		<Province/>
		<City/>
	</BankAccount>
  </Body>
</Request>
XML;

$xmltx1312=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1312</TxCode>
  </Head>
  <Body>
    <InstitutionID/>
    <OrderNo/>
	<PaymentNo/>
    <Amount/>
	<PayerID/>
    <PayerName/>
	<Usage/>
    <Remark/>
	<NotificationURL/>
	<PayeeList/>
   </Body>
</Request>
XML;

$xmltx1133=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1133</TxCode>
  </Head>
  <Body>
    <InstitutionID/>
		<SerialNumber/>
		<PaymentNo/>
		<Amount/>
		<Remark/>
  </Body>
</Request>
XML;

$xmltx1138=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1138</TxCode>
  </Head>
  <Body>
	<InstitutionID/>
	<SerialNumber/>
	<PaymentNo/>
	<Amount/>
	<Status/>
	<RefundTime/>
  </Body>
</Request>
XML;

$xmlNotification=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Response version="2.0">
<Head>
	<Code/>
	<Message/>
</Head>
</Response>
XML;

/**
 PayeeList can be composited by several Payees.
*/
$xmltx1311=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
	<Head>
		<TxCode>1311</TxCode>
	</Head>
	<Body>
		<InstitutionID/>
		<OrderNo/>
		<PaymentNo/>
		<Amount/>
		<Remark/>
		<NotificationURL/>
		<PayeeList/>
		<BankID/>
		<AccountType/>
	</Body>
</Request>
XML;

$xmltx1320=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1320</TxCode>
  </Head>
  <Body>
    <InstitutionID/>
    <PaymentNo/>
  </Body>
</Request>
XML;

$xmltx1330=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1330</TxCode>
  </Head>
  <Body>
    <InstitutionID/>
    <OrderNo/>
  </Body>
</Request>
XML;

$xmltx1341=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1341</TxCode>
  </Head>
  <Body>
	<InstitutionID/>
	<SerialNumber/>
	<OrderNo/>
	<Amount/>
	<Remark/>
	<AccountType/>
	<PaymentAccountName/>
	<PaymentAccountNumber/>
	<BankAccount>
	<BankID/>
	<AccountName/>
	<AccountNumber/>
	<BranchName/>
	<Province/>
	<City/>
	</BankAccount>
  </Body>
</Request>
XML;

$xmltx1343=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1343</TxCode>
  </Head>
  <Body>
    <InstitutionID/>
    <SerialNumber/>
    <OrderNo/>
    <Amount/>
	<Remark/>
	<AccountType/>
    <PaymentAccountName/>
 	<PaymentAccountNumber/>
	<BankAccount>
		<BankID/>
		<AccountName/>
		<AccountNumber/>
		<BranchName/>
		<Province/>
		<City/>
	</BankAccount>
  </Body>
</Request>
XML;


$xmltx1361=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
<Head>
<InstitutionID/>
<TxCode/>
<OrderNo/>
<TxSN/>
</Head>
<Body>
<Amount/>
<BankID/>
<AccountType/>
<AccountName/>
<AccountNumber/>
<BranchName/>
<Province/>
<City/>
<ValidDate/>
<CVN2/>
<IdentificationType/>
<IdentificationNumber/>
<Note/>
<ContractUserID/>
<PhoneNumber/>
<Email/>
<PayeeList/>
</Body>
</Request>
XML;

$xmltx1362=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
<Head>
<InstitutionID/>
<TxCode/>
<TxSN/>
</Head>
</Request>
XML;

$xmltx1711=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
	<Head>
	    <InstitutionID/>
		<TxCode>1711</TxCode>
	</Head>
	<Body>
		<OrderNo/>
		<Amount/>
		<PayerID/>
		<PayerName/>
		<Usage/>
		<Remark/>
		<PageURL/>
		<BankID/>
		<AccountType/>
	</Body>
</Request>
XML;

$xmltx1713=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
	<Head>
	    <InstitutionID/>
		<TxCode>1713</TxCode>
	</Head>
	<Body>
		<OrderNo/>
	</Body>
</Request>
XML;

$xmltx1721=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
	<Head>
	    <InstitutionID/>
		<TxCode>1721</TxCode>
		<TxSN/>
	</Head>
	<Body>
		<OrderNo/>
		<Remark/>
	</Body>
</Request>
XML;

$xmltx1723=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
	<Head>
	    <InstitutionID/>
		<TxCode>1723</TxCode>
		<TxSN/>
	</Head>
</Request>
XML;

$xmltx1731=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
	<Head>
	    <InstitutionID/>
		<TxCode>1731</TxCode>
		<TxSN/>
	</Head>
	<Body>
		<OrderNo/>
		<Amount/>
		<Remark/>
	</Body>
</Request>
XML;

$xmltx1733=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
	<Head>
	    <InstitutionID/>
		<TxCode>1733</TxCode>
		<TxSN/>
	</Head>
</Request>
XML;

$xmltx1741=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
  	<InstitutionID/>
    <TxCode>1741</TxCode>
	<TxSN/>
  </Head>
  <Body>
	<OrderNo/>
	<Amount/>
	<Remark/>
	<AccountType/>
	<BankAccount>
	<BankID/>
	<AccountName/>
	<AccountNumber/>
	<BranchName/>
	<Province/>
	<City/>
	</BankAccount>
  </Body>
</Request>
XML;

$xmltx2011=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
  	<InstitutionID/>
    <TxCode>2011</TxCode>
		<TxSN/>
  </Head>
  <Body>
		<Amount/>
		<BankID/>
		<AccountType/>
		<ValidDate/>
		<CVN2/>
		<AccountName/>
		<AccountNumber/>
		<BranchName/>
		<Province/>
		<City/>
		<IdentificationType/>
		<IdentificationNumber/>
		<Note/>
		<ContractUserID/>
		<PhoneNumber/>
		<Email/>
		<SettlementFlag/>
  </Body>
</Request>
XML;

$xmltx2020=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
  	<InstitutionID/>
  	<TxCode>2020</TxCode>
  	<TxSN/>
  </Head>
</Request>
XML;

$xmltx1810=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request version="2.0">
  <Head>
    <TxCode>1810</TxCode>
  </Head>
  <Body>
	<InstitutionID/>
    <Date/>
  </Body>
</Request>
XML;

$xmltx3211=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
	<Head>
		<TxCode>3211</TxCode>
		<InstitutionID/>
	</Head>
	<Body>
		<ProjectNo/>
		<PaymentNo/>
		<Amount/>
		<ProjectName/>
		<ProjectURL/>
		<ProjectScale/>
		<ReturnRate/>
		<ProjectPeriod/>
		<StartDate/>
		<EndDate/>
		<LoanerPaymentAccountNumber/>
		<LoaneeAccountType/>
		<LoaneeBankID/>
		<LoaneeBankAccountName/>
		<LoaneeBankAccountNumber/>
		<LoaneePaymentAccountName/>
		<LoaneePaymentAccountNumber/>
		<GuaranteeAccountType/>
		<GuaranteeBankID/>
		<GuaranteeBankAccountName/>
		<GuaranteeBankAccountNumber/>
		<GuaranteePaymentAccountName/>
		<GuaranteePaymentAccountNumber/>
		<PageURL/>
	</Body>
</Request>
XML;

$xmltx3216=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>3216</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
    <PaymentNo/>
  </Body>
</Request>
XML;

$xmltx3218=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>3218</TxCode>
  </Head>
  <Body>
    <InstitutionID/>
    <PaymentNo/>
    <PaymentTime/>
    <Amount/>
    <LoanerPaymentAccountNumber/>
    <PaymentWay/>
  </Body>
</Request>
XML;

$xmltx3231=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>3231</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<SerialNumber/>
  	<ProjectNo/>
    <PaymentNo/>
    <SettlementType/>
    <AccountType/>
    <BankID/>
    <BankAccountName/>
    <BankAccountNumber/>
    <BankBranchName/>
    <BankProvince/>
    <BankCity/>
    <PaymentAccountName/>
    <PaymentAccountNumber/>
    <Amount/>
    <Remark/>
  </Body>
</Request>
XML;

$xmltx3236=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>3236</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<SerialNumber/>
  </Body>
</Request>
XML;

$xmltx3241=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>3241</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<SerialNumber/>
  	<ProjectNo/>
    <RepaymentType/>
    <AccountType/>
    <BankID/>
    <BankAccountName/>
    <BankAccountNumber/>
    <BankProvince/>
    <BankCity/>
    <PaymentAccountName/>
    <PaymentAccountNumber/>
    <Amount/>
    <Remark/>
  </Body>
</Request>
XML;

$xmltx3246=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>3246</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<SerialNumber/>
  </Body>
</Request>
XML;


$xmltx4231=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4231</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<PhoneNumber/>
  	<UserName/>
  	<IdentificationNumber/>
  	<UserType/>
  	<PageURL/>
  </Body>
</Request>
XML;

$xmltx4232=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4232</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<PhoneNumber/>
  </Body>
</Request>
XML;

$xmltx4233=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4233</TxCode>
  </Head>
  <Body>
  	<InstitutionID/>
  	<PhoneNumber/>
  	<UserName/>
  	<IdentificationNumber/>
  	<PaymentAccountNumber/>
  </Body>
</Request>
XML;

$xmltx4235=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4235</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<PaymentAccountNumber/>
  </Body>
</Request>
XML;

$xmltx4237=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4237</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<PaymentAccountNumber/>
  </Body>
</Request>
XML;

$xmltx4241=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4241</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<PaymentAccountNumber/>
  	<PageURL/>
  </Body>
</Request>
XML;

$xmltx4243=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4243</TxCode>
  </Head>
  <Body>
  	<InstitutionID/>
  	<PaymentAccountNumber/>
  	<BankID/>
  	<BindingSystemNo/>
  	<BankAccountNumber/>
  </Body>
</Request>
XML;

$xmltx4244=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4244</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<PaymentAccountNumber/>
  </Body>
</Request>
XML;

$xmltx4245=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4245</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<PaymentAccountNumber/>
  	<BindingSystemNo/>
  	<PageURL/>
  </Body>
</Request>
XML;

$xmltx4247=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4247</TxCode>
  </Head>
  <Body>
  	<InstitutionID/>
  	<BindingSystemNo/>
  	<PaymentAccountNumber/>
  	<BankID/>
  	<BankAccountNumber/>
  </Body>
</Request>
XML;

$xmltx4251=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4251</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<PaymentAccountNumber/>
  	<PaymentNo/>
  	<Amount/>
  	<PageURL/>
  </Body>
</Request>
XML;

$xmltx4252=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4252</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<PaymentNo/>
  </Body>
</Request>
XML;

$xmltx4253=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4253</TxCode>
  </Head>
  <Body>
  	<InstitutionID/>
  	<PaymentAccountNumber/>
  	<PaymentNo/>
  	<Amount/>
  	<PaymentTime/>
  </Body>
</Request>
XML;

$xmltx4255=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4255</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<PaymentAccountNumber/>
  	<TxSN/>
  	<Amount/>
  	<PageURL/>
  </Body>
</Request>
XML;

$xmltx4256=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4256</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<TxSN/>
  </Body>
</Request>
XML;

$xmltx4257=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4257</TxCode>
  </Head>
  <Body>
  	<InstitutionID/>
  	<PaymentAccountNumber/>
  	<TxSN/>
  	<Amount/>
  	<AcceptTime/>
  </Body>
</Request>
XML;

$xmltx4261=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4261</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<AgreementNo/>
  	<PaymentAccountNumber/>
  	<PageURL/>
  </Body>
</Request>
XML;

$xmltx4262=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4262</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<AgreementNo/>
  </Body>
</Request>
XML;

$xmltx4263=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4263</TxCode>
  </Head>
  <Body>
  	<InstitutionID/>
  	<AgreementNo/>
  	<PaymentAccountName/>
  	<PaymentAccountNumber/>
  	<IdentificationNumber/>
  	<PhoneNumber/>
  </Body>
</Request>
XML;

$xmltx4264=<<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request>
  <Head>
    <TxCode>4264</TxCode>
    <InstitutionID/>
  </Head>
  <Body>
  	<AgreementNo/>
  </Body>
</Request>
XML;

?>
