<?php
include 'lang/GermanWords.php';
include 'config/route.php';
if(!isset($_SESSION['access_token'])) {
    header('Location: '.$absoluteUrl.'login');
}
include 'inc/header.php';
include 'inc/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>SymCom</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container box box-success">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-header with-border">
                        <h1>Bearbeitungssoftware für die homöopathischen Arzneimittelprüfungen aus dem 19. Jahrhundert</h1>
                    </div>
                    <div class="box-body">
                        <h2>Dr. med. Carl Rudolf Klinkenberg</h2>
                        <p>Die Homöopathie wurde von dem Arzt und Apotheker Samuel Hahnemann (1755-1843) entwickelt und ist heute in vielen Ländern weltweit verbreitet. Die Wirkung homöopathischer Arzneimittel wurde in Arzneimittelprüfungen an gesunden Menschen ermittelt. In der Anfangszeit der Homöopathie, am Beginn des 19ten Jahrhunderts, wurden Pflanzen und Mineralien geprüft, die bereits seit Jahrhundertenin der Volksmedizin angewandt worden waren, wie z.B. Digitalis, Arnika oder Chinarinde. Auf die Beobachtungen aus diesen Arzneiprüfungen stützt sich die Mittelwahl beim Kranken. Die bis heute genauesten und damit besten Arzneiprüfungen stammen aus der ersten Hälfte des 19. Jahrhunderts. Überwiegend sind sie deutschsprachig, ein Teil ist englischsprachig. Die deutschsprachigen Arzneiprüfungen enthalten ca. 500.000 Symptombeschreibungen, die in Symptomverzeichnissen (Materia medicae) geordnet wurden. Die Materia medica ist ein Verzeichnis der Wirkungen homöopathisch geprüfter Arzneistoffe. Sie wird zur Auswahl der passenden Arznei im Krankheitsfall herangezogen. Es klingt schwer nachvollziehbar, aber bis heute wurden die Quellen zwar genutzt, aber trotz vieler Fehler und Probleme nicht systematisch aufgearbeitet. Ziel und Zweck unserer Arbeit ist die erstmalige Schaffung einer primären Materia medica als grundlegendes Nachschlagewerk für homöopathische Ärzte weltweit. Darüber hinaus ist die neue Materia medica die erstmalige wissenschaftliche Aufarbeitung und Dokumentation der Quellen der Homöopathie.</p>
                        <h2>Fehler in den Symptomverzeichnissen</h2>
                        <p>In Deutschland wurden Arzneiprüfungen von 1805 bis 1900 in Einzelpublikationen, Sammelwerkenund Zeitschriftenbeiträgenveröffentlicht und sukzessive in Sammelwerken zusammengefasst. Diese wiederum wurden in mehreren Auflagen veröffentlicht. Zu den ersten Sammelwerken zählen die „Reine Arzneimittellehre“(1811-1833) und die „Chronischen Krankheiten“ (1828-39) von S. Hahnemann sowie die „Reine Arzneimittellehre“ (18281831) von C.C. Hartlaub und C.F. Trinks. Die heute verfügbare Materia medica greift auf die jeweils letzten Auflagen dieser Sammelwerke zurück. Dabei sind folgende Probleme aufgetreten: 1. Bei der Zusammenstellung der Symptomverzeichnisse aus Einzelpublikationen und Zeitschriften sind die Symptome teilweise bearbeitet und verändert worden. 2. Bei der handschriftlichen Übertragung der Symptome aus früheren in spätere Auflagen sind Übertragungsfehler aufgetreten, wahrscheinlich durch Abschreiben. 3. Schließlich wurde das umfangreichste Sammelwerk Hahnemanns, die „Chronischen Krankheiten“ (1828-39), auf die alle heutigen Nachschlagewerke zurückgreifen, in seiner letzten Ausgabe einer umfangreichen Bearbeitung derSymptome unterzogen. Dies hat zur Folge, dass der Arzt heute nicht mehr auf die korrekten, detaillierteren Symptombeschreibungen der Originalprüfungen zurückgreifen kann.Im Folgenden sind einige der typischen Abweichungen und Fehler, die auftreten, aufgelistet (siehe auch Anlage 1):</p>
                        <ul>
                            <li>Auslassung von Symptomen</li>
                            <li>Verwechselungen von Lokalisationen oder Seiten</li>
                            <li>Auslassung von Symptomdetails, z.B. einer Lokalisation oder eines Begleitsymptoms</li>
                            <li>Wegfall einer genauer beschreibenden Information</li>
                            <li>Wegfall von Zeitangaben</li>
                            <li>Sinnveränderungen durch Verwendung anderer Begriffe oder unechter Synonyme</li>
                            <li>Umstellung von Satzteilen mit Verschiebung der Bedeutungsgewichtung</li>
                            <li>Spaltung eines Symptoms in mehrere einzelne Symptombeschreibungen</li>
                            <li>Zusammenfassung zweier oder mehrerer Symptome zu einem Symptom</li>
                            <li>Wegfall von Hervorhebungen, z.B. Sperrdruck</li>
                            <li>Doppelungenvon Symptomen(Parallelzitationen)</li>
                            <li>unterschiedliche sprachliche Varianten und Schreibweise</li>
                        </ul>
                        <h2>Vergleich der Symptome und Erstellung einer Primärquellen-Materia medica</h2>
                        <p>Um diese Fehler aufzudecken nutzen wir informationstechnologische Methoden in Form einer interaktiven, webbasierten Arbeitsumgebung, das Bearbeitungsprogramm SymCom (siehe Anlage 2). Zuerst werden die originalen Arzneiprüfungen in texteditierbarer Form erfasst und in SymCom importiert. Wir vergleichen die Prüfungssymptome einer Arznei in den Einzelpublikationen undden verschiedenen Auflagender Sammelwerkemiteinander, ermitteln die Originalsymptome und hinterlegen den Originalsymptomen spätere Symptomvarianten als Zusatzinformationen</p>
                        <h2>Sinn des Symptomvergleichs</h2>
                        <p>Durch die Hinterlegung der Symptomvarianten werden die Abweichungen von Symptombeschreibungen in späteren Quellen nachvollziehbar. Wir identifizieren durch den Vergleich Symptome, die in späteren Quellen neu hinzugefügt wurden und erweitern auf diese Weise die Primärquellen-Materia medica. Durch den Vergleich werden außerdem Informationen erkennbar, die in späteren Auflagen hinzugefügt wurden, wie z.B. die Höherstufung/Gradierung eines Symptoms durch Sperrdruck nach klinischer Verifikation beim Kranken. Gradierungen von Symptomen sind wichtige zusätzliche Informationen, die wir nach kritischer Prüfung in die Materia medica einarbeiten.</p>
                        <h2>Hinterlegung von Metastrukturen</h2>
                        <p>Die Materia medica wird in der Praxis für den Symptomenvergleich benötigt. Deshalb soll sie in einem zweiten Schritt für Such- und Analysefunktionen zum Zwecke der Arzneidifferenzierung vorbearbeitet werden. Hierfür werden die Symptome analysiert und codiert, d.h. mit Zusatzinformationen (Metadaten) versehen. Die Codierung mit Metadatenmuss alle sinnvollen Anwendungsmöglichkeiten für die Praxis abdecken. Alle Aspekte einer Symptombeschreibung werden mit einbezogen. Hierfür einige Beispiele:</p>
                        <ul>
                            <li>Codierung derSymptomelemente(Symptomelementesind Empfindungen wie Brennen, Lokalisationen wie Stirn und Modalitäten, d.h. Umstände der Verschlimmerung / Besserung)</li>
                            <li>Frühere, veraltete medizinische Begriffewerden mit heute gebräuchlichen Begriffen codiert, z.B. Heiligenbein / Kreuzbein, unterköthig / unter der Haut.</li>
                            <li>Hierarchische Zuordnungen von Symptomen: Stirn als Teil vom Kopf</li>
                            <li>Verknüpfung von Pluralismen, z.B. Apfel / Äpfel</li>
                            <li>Synonyme in Abstufungen: 1. eng: Benommenheit / Eingenommenheit. 2. entfernt: Wanken / Schwanken</li>
                            <li>Querverweise: Wanken / Taumeln</li>
                            <li>Sprachliche Ableitungen: Stirn / Stirne, Sauer / Saures</li>
                            <li>Synonyme Schreibweisen: Schweiss / Schweiß, Atem / Athem</li>
                            <li>Generalisierungen: Hitzegefühl / Temperaturveränderung, Bauchspeicheldrüse / Drüsen, Atemnot / Atmung</li>
                            <li>Verknüpfungen von zusammengehörigen Symptomteilen, z.B. bei dem Symptom „Morgens schwindelig, mit Übelkeit im Magen und Frost über den ganzen Körper, besonders am Abend.“ Morgens / Schwindel + Abends / Frost</li>
                        </ul>
                        <h2>Klärung der Wortbedeutungen</h2>
                        <p>Die frühenArzneimittelprüfungen wurden in der Sprache des 19. Jahrhunderts verfasst. Viele Begriffe wie „Hoffart“, „Leibschneiden“ oder „Mattherzigkeit“ sind heute nicht mehr gebräuchlich. Bei anderen Worten haben sichdieBedeutungen verschoben, z.B. bei dem Begriff „Unannehmlichkeit“. Die genaue Klärung der Wortbedeutungen ist ein Teilbereich der Bearbeitung mit Metadaten. Die Bedeutung und der Bedeutungsumfang einzelner Begriffe oder Redewendungen werden mit Sprachwörterbüchern (Adelung, Grimm, Campe und Sanders)geklärt und definiert. Mit der Hinzufügung der Metastrukturen lernt das Programm sukzessive über jeden in den Symptomen vorkommenden Begriff dazu; einvon einem Bearbeiter einmal hinterlegtes Synonym oder eine hierarchische Zuordnung ist von jetzt ab an in der Datenbank abrufbar. Das vereinfacht nach und nach die Arbeit, indem alle für ein Symptom bereits hinterlegten Informationen dem Bearbeiter angezeigt werden.</p>
                        <h2>Neues Repertorium</h2>
                        <p>Durch die Hinterlegung von Metastrukturen wird begleitend vom Programm die Indexierung der Daten vorgenommen. Das Repertorium ist der Index, die als Suchmaschine strukturierte Materia medica. Aus der geordneten und strukturierten Sammlung von Arzneisymptomen, der Materia Medica, soll das Programm einen Index, quasi die umgekehrte Materia Medica erstellen. Der Nutzer gibt Symptome ein, die Suchmaschine schlägt ihm passende Arzneimittel vor. Dies ist das alltägliche Werkzeug des Homöopathen.</p>
                        <h2>Projektrahmen</h2>
                        <p>Das Neue Repertorium ist eine Initiative von Dr. med. Carl Rudolf Klinkenberg in Zusammenarbeit mit Kollegen. Die Arbeit ist ein Projekt der Wissenschaftlichen Gesellschaft für Homöopathie (WissHom). Ein Beirat begleitet das Projekt fachlich und konzeptionell. Mitglieder des Beirates sind Dr. med. Klaus Holzapfel (Stuttgart), Dr. med. Andreas Wegener (Konstanz), Dr. K.S. Srinivasan (Chennai, Indien), Stefan Reis, Dr. Norbert Winter (Karlsruhe) und Dr. Daniel Cook (USA).</p>
                        <h2>Projektleitung</h2>
                        <div class="project-manager-cnr">
                            <div class="img-cnr">
                                <img  class="img-responsive" src="<?php echo $absoluteUrl;?>assets/img/carl.png" alt="Dr. med. Carl Rudolf Klinkenberg">
                            </div>
                            <p>Dr. med. Carl Rudolf Klinkenberg, Jahrgang 1961 ist Facharzt für Allgemeinmedizin. Wissenschaftliche Promotion mit Auszeichnung an der Uniklinik Tübingen bei Prof. Dr. D. Niethammer über humane Neuroblastomzellen. Dr. Klinkenberg ist seit 1993 in homöopathischer Privatpraxis niedergelassen. Seit 1997 regelmäßige Veröffentlichungen in der Zeitschrift für Klassische Homöopathie und anderen Zeitschriften über schwere Krankheitsfälle, homöopathische Krebsbehandlung, ADHS, psychische Krankheiten, Verifikationen und andere Themen. Erster Preisträger des Emil-Schlegel-Preises für die Arbeit „Leitlinien zur homöopathischen Krebsbehandlung“ 1999. Internationale Vortragstätigkeit (LIGA, internationale Kongresse) und Seminartätigkeit. 2004 bis 2014 Dozent in der ärztlichen Weiterbildung. Dr. Klinkenberg war Gründer und Präsident des Internationalen Hahnemann Congress 2007 in Ettlingen und Leiter des Internationalen Cöthener Erfahrungsaustauschs 2009 in Köthen. Seit 2007 arbeitet er an der Revision der homöopathischen Materia medica.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
include 'inc/footer.php';
?>